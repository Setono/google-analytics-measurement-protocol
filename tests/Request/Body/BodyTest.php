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
            json_encode($body),
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
            json_encode($body),
        );
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
