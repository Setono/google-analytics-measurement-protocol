<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

use PHPUnit\Framework\TestCase;

class AddShippingInfoEventTest extends TestCase
{
    /**
     * @test
     */
    public function it_returns_array(): void
    {
        $event = new AddShippingInfoEvent();
        $event->parameters->coupon = 'SUMMER_SALE';
        $event->parameters->currency = 'USD';
        $event->parameters->value = 123.95;
        $event->parameters->shippingTier = 'Next-day';

        $item = new GenericItemEventParameters();
        $item->itemId = 'GUCCI_BAG_1234';

        $event->parameters->addItem($item);

        self::assertSame([
            'name' => 'add_shipping_info',
            'params' => [
                'coupon' => 'SUMMER_SALE',
                'currency' => 'USD',
                'value' => 123.95,
                'shipping_tier' => 'Next-day',
                'items' => [
                    ['item_id' => 'GUCCI_BAG_1234'],
                ],
            ],
        ], $event->toArray());
    }
}
