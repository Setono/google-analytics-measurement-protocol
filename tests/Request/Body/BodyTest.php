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
            ->withPersonalizedAds(true)
        ;

        self::assertSame(
            '{"client_id":"CLIENT_ID","user_id":"USER_ID","timestamp_micros":1668509674013800,"non_personalized_ads":false,"events":[{"name":"add_to_cart","params":{"currency":"USD","value":123.45}}]}',
            json_encode($body),
        );
    }
}

/**
 * This will override the PHP function microtime for test purposes (as long as we don't use backslash when using microtime in our code
 */
function microtime(): float
{
    return 1668509674.0138;
}
