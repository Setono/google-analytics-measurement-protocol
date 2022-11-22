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
}

/**
 * This effectively overrides the 'microtime' function in PHP if the function is not namespaced like \microtime when used
 */
function microtime(): float
{
    return 1668509674.0138;
}
