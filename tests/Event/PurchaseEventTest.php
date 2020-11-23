<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

use PHPUnit\Framework\TestCase;

final class PurchaseEventTest extends TestCase
{
    /**
     * @test
     */
    public function it_returns_array(): void
    {
        $event = new PurchaseEvent();
        $event->parameters->affiliation = 'Web';
        $event->parameters->coupon = 'SUMMER_SALE';
        $event->parameters->currency = 'USD';
        $event->parameters->transactionId = 'trans_1234';
        $event->parameters->shipping = 12.05;
        $event->parameters->tax = 9.25;
        $event->parameters->value = 123.95;

        $item = new ItemEventParameters();
        $item->itemId = 'GUCCI_BAG_1234';

        $event->parameters->addItem($item);

        self::assertSame([
            'name' => 'purchase',
            'params' => [
                'affiliation' => 'Web',
                'coupon' => 'SUMMER_SALE',
                'currency' => 'USD',
                'transaction_id' => 'trans_1234',
                'shipping' => 12.05,
                'tax' => 9.25,
                'value' => 123.95,
                'items' => [
                    ['item_id' => 'GUCCI_BAG_1234'],
                ],
            ],
        ], $event->toArray());
    }
}
