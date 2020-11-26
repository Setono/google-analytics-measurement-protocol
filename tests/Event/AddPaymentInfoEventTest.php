<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

use PHPUnit\Framework\TestCase;

final class AddPaymentInfoEventTest extends TestCase
{
    /**
     * @test
     */
    public function it_returns_array(): void
    {
        $event = new AddPaymentInfoEvent();
        $event->parameters->coupon = 'SUMMER_SALE';
        $event->parameters->currency = 'USD';
        $event->parameters->value = 123.95;
        $event->parameters->paymentType = 'Credit Card';

        $item = new GenericItemEventParameters();
        $item->itemId = 'GUCCI_BAG_1234';

        $event->parameters->addItem($item);

        self::assertSame([
            'name' => 'add_payment_info',
            'params' => [
                'coupon' => 'SUMMER_SALE',
                'currency' => 'USD',
                'value' => 123.95,
                'payment_type' => 'Credit Card',
                'items' => [
                    ['item_id' => 'GUCCI_BAG_1234'],
                ],
            ],
        ], $event->toArray());
    }
}
