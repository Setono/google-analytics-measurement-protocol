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
        $event->parameters->affiliation = 'Google Store';
        $event->parameters->coupon = 'SUMMER_FUN';
        $event->parameters->currency = 'USD';
        $event->parameters->transactionId = 'T_12345';
        $event->parameters->shipping = 3.33;
        $event->parameters->tax = 1.11;
        $event->parameters->value = 12.21;

        $item = new GenericItemEventParameters();
        $item->itemId = 'SKU_12345';

        $event->parameters->addItem($item);

        self::assertSame([
            'name' => 'purchase',
            'params' => [
                'affiliation' => 'Google Store',
                'coupon' => 'SUMMER_FUN',
                'currency' => 'USD',
                'transaction_id' => 'T_12345',
                'shipping' => 3.33,
                'tax' => 1.11,
                'value' => 12.21,
                'items' => [['item_id' => 'SKU_12345']],
            ],
        ], $event->toArray());
    }
}
