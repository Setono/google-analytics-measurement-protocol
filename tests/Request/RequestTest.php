<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request;

use PHPUnit\Framework\TestCase;
use Setono\GoogleAnalyticsEvents\Event\AddToCartEvent;

/**
 * @covers \Setono\GoogleAnalyticsMeasurementProtocol\Request\Request
 */
final class RequestTest extends TestCase
{
    /**
     * @test
     */
    public function it_initializes(): void
    {
        $request = self::getRequest();

        self::assertSame('API_SECRET', $request->getApiSecret());
        self::assertSame('G-12341234', $request->getMeasurementId());
        self::assertSame('CLIENT_ID', $request->getClientId());
        self::assertSame(1_668_509_674_013_800, $request->getTimestamp());

        $payload = $request->getPayload();
        self::assertArrayHasKey('client_id', $payload);
        self::assertArrayHasKey('timestamp_micros', $payload);
    }

    /**
     * @test
     */
    public function it_is_mutable(): void
    {
        // first create the initial request object
        $event = AddToCartEvent::create()
            ->setCurrency('USD')
            ->setValue(123.45)
        ;

        $request = self::getRequest()
            ->setUserId('USER_ID')
            ->addEvent($event)
            ->setUserProperty('prop', 'val')
            ->setTimestamp(1_668_509_674_013_800)
            ->setNonPersonalizedAds(true)
        ;

        // then assert its values
        self::assertSame('CLIENT_ID', $request->getClientId());
        self::assertSame('USER_ID', $request->getUserId());

        $events = $request->getEvents();
        self::assertCount(1, $events);
        self::assertSame($event, $events[0]);

        $userProperties = $request->getUserProperties();
        self::assertCount(1, $userProperties);
        self::assertArrayHasKey('prop', $userProperties);
        self::assertSame('val', $userProperties['prop']);

        self::assertSame(1_668_509_674_013_800, $request->getTimestamp());
        self::assertTrue($request->getNonPersonalizedAds());

        // then mutate the object
        $newEvent = AddToCartEvent::create()
            ->setCurrency('USD')
            ->setValue(123.45)
        ;

        $request->setClientId('NEW_CLIENT_ID')
            ->setUserId('NEW_USER_ID')
            ->setTimestamp(1_668_509_674_013_900)
            ->setNonPersonalizedAds(null)
            ->setEvents([$newEvent])
            ->setUserProperty('prop', 'new_val')
        ;

        // then assert its values again
        self::assertSame('NEW_CLIENT_ID', $request->getClientId());
        self::assertSame('NEW_USER_ID', $request->getUserId());

        $events = $request->getEvents();
        self::assertCount(1, $events);
        self::assertSame($newEvent, $events[0]);

        $userProperties = $request->getUserProperties();
        self::assertCount(1, $userProperties);
        self::assertArrayHasKey('prop', $userProperties);
        self::assertSame('new_val', $userProperties['prop']);

        self::assertSame(1_668_509_674_013_900, $request->getTimestamp());
        self::assertNull($request->getNonPersonalizedAds());
    }

    /**
     * @test
     */
    public function it_serializes(): void
    {
        $body = self::getRequest()
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
            json_encode($body->getPayload(), \JSON_THROW_ON_ERROR),
        );
    }

    /**
     * @test
     */
    public function it_throws_exception_if_number_of_events_is_exceeded(): void
    {
        $this->expectException(\OutOfBoundsException::class);
        $request = self::getRequest();

        for ($i = 0; $i < 26; ++$i) {
            $request->addEvent(
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
        $request = self::getRequest();

        for ($i = 0; $i < 25; ++$i) {
            $request->addEvent(
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

        $request = self::getRequest();
        $request->setUserProperty($userProperty, 'value');
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

    private static function getRequest(): Request
    {
        return new Request('G-12341234', 'API_SECRET', 'CLIENT_ID');
    }
}

/**
 * This effectively overrides the 'microtime' function in PHP if the function is not namespaced like \microtime when used
 */
function microtime(): float
{
    return 1_668_509_674.0138;
}
