<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event;

use PHPUnit\Framework\TestCase;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Item\Item;

/**
 * @covers \Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\AddToCartEvent
 */
final class AddToCartEventTest extends TestCase
{
    /**
     * @test
     */
    public function it_serializes(): void
    {
        $event = AddToCartEvent::create('USD', 123.45)
            ->withItem(Item::create('SKU1234', 'Blue t-shirt'))
        ;

        self::assertSame(
            '{"name":"add_to_cart","params":{"currency":"USD","value":123.45,"items":[{"item_id":"SKU1234","item_name":"Blue t-shirt","quantity":1}]}}',
            json_encode($event),
        );
    }
}
