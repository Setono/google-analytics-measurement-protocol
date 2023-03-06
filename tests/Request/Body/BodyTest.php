<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body;

use PHPUnit\Framework\TestCase;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\AddToCartEvent;

/**
 * @covers \Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Body
 */
final class BodyTest extends TestCase
{
    /**
     * @test
     */
    public function it_it_mutable(): void
    {
        // first create the initial Body object
        $event = AddToCartEvent::create()
            ->setCurrency('USD')
            ->setValue(123.45)
        ;

        $body = Body::create('CLIENT_ID')
            ->setUserId('USER_ID')
            ->addEvent($event)
            ->setUserProperty('prop', 'val')
            ->setTimestamp(1_668_509_674_013_800)
            ->setNonPersonalizedAds(true)
        ;

        // then assert its values
        self::assertSame('CLIENT_ID', $body->getClientId());
        self::assertSame('USER_ID', $body->getUserId());

        $events = $body->getEvents();
        self::assertCount(1, $events);
        self::assertSame($event, $events[0]);

        $userProperties = $body->getUserProperties();
        self::assertCount(1, $userProperties);
        self::assertArrayHasKey('prop', $userProperties);
        self::assertSame('val', $userProperties['prop']);

        self::assertSame(1_668_509_674_013_800, $body->getTimestamp());
        self::assertTrue($body->getNonPersonalizedAds());

        // then mutate the object
        $newEvent = AddToCartEvent::create()
            ->setCurrency('USD')
            ->setValue(123.45)
        ;

        $body->setClientId('NEW_CLIENT_ID')
            ->setUserId('NEW_USER_ID')
            ->setTimestamp(1_668_509_674_013_900)
            ->setNonPersonalizedAds(null)
            ->setEvents([$newEvent])
            ->setUserProperty('prop', 'new_val')
        ;

        // then assert its values again
        self::assertSame('NEW_CLIENT_ID', $body->getClientId());
        self::assertSame('NEW_USER_ID', $body->getUserId());

        $events = $body->getEvents();
        self::assertCount(1, $events);
        self::assertSame($newEvent, $events[0]);

        $userProperties = $body->getUserProperties();
        self::assertCount(1, $userProperties);
        self::assertArrayHasKey('prop', $userProperties);
        self::assertSame('new_val', $userProperties['prop']);

        self::assertSame(1_668_509_674_013_900, $body->getTimestamp());
        self::assertNull($body->getNonPersonalizedAds());
    }

    /**
     * @test
     */
    public function it_serializes(): void
    {
        $body = Body::create('CLIENT_ID')
            ->setUserId('USER_ID')
            ->addEvent(
                AddToCartEvent::create()
                    ->setCurrency('USD')
                    ->setValue(123.45),
            )
            ->setUserProperty('prop', 'val')
            ->setTimestamp(1_668_509_674_013_800)
            ->setNonPersonalizedAds(true)
        ;

        self::assertSame(
            '{"client_id":"CLIENT_ID","user_id":"USER_ID","timestamp_micros":1668509674013800,"user_properties":{"prop":"val"},"non_personalized_ads":true,"events":[{"name":"add_to_cart","params":{"currency":"USD","value":123.45}}]}',
            json_encode($body->getPayload()),
        );
    }

    /**
     * @test
     */
    public function it_handles_microtime(): void
    {
        $body = Body::create('CLIENT_ID');

        self::assertSame(
            '{"client_id":"CLIENT_ID","timestamp_micros":1668509674013800}',
            json_encode($body->getPayload()),
        );
    }

    /**
     * @test
     */
    public function it_throws_exception_if_number_of_events_is_exceeded(): void
    {
        $this->expectException(\OutOfBoundsException::class);
        $body = Body::create('CLIENT_ID');

        for ($i = 0; $i < 26; ++$i) {
            $body->addEvent(
                AddToCartEvent::create()
                ->setCurrency('USD')
                ->setValue(123.45),
            );
        }
    }

    /**
     * @test
     */
    public function it_does_not_throw_exception_if_number_of_events_hits_the_limit(): void
    {
        $body = Body::create('CLIENT_ID');

        for ($i = 0; $i < 25; ++$i) {
            $body->addEvent(
                AddToCartEvent::create()
                ->setCurrency('USD')
                ->setValue(123.45),
            );
        }

        self::assertTrue(true);
    }

    /**
     * @test
     *
     * @dataProvider getInvalidUserProperties
     */
    public function it_throws_exception_if_user_property_is_invalid(string $userProperty): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $body = Body::create('CLIENT_ID');
        $body->setUserProperty($userProperty, 'value');
    }

    /**
     * @return \Generator<array-key, array<array-key, string>>
     */
    public function getInvalidUserProperties(): \Generator
    {
        // these are illegal user property names
        yield ['first_open_time'];
        yield ['first_visit_time'];
        yield ['last_deep_link_referrer'];
        yield ['user_id'];
        yield ['first_open_after_install'];

        // these user properties are deemed illegal because of their prefixes
        yield ['google_test'];
        yield ['ga_test'];
        yield ['firebase_test'];
    }
}

/**
 * This effectively overrides the 'microtime' function in PHP if the function is not namespaced like \microtime when used
 */
function microtime(): float
{
    return 1668509674.0138;
}
