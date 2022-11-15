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
        $body = Body::create('CLIENT_ID', 'USER_ID')
            ->withEvent(AddToCartEvent::create('USD', 123.45))
            ->withTimestamp(1_668_509_674_013_800)
            ->withPersonalizedAds(true)
        ;

        self::assertSame(
            '{"client_id":"CLIENT_ID","user_id":"USER_ID","timestamp_micros":1668509674013800,"non_personalized_ads":false,"events":[{"name":"add_to_cart","params":{"currency":"USD","value":123.45}}]}',
            json_encode($body),
        );
    }
}
