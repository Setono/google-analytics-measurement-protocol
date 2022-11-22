<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event;

use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Item\Item;

/**
 * @covers \Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\AddPaymentInfoEvent
 */
final class AddPaymentInfoEventTest extends AbstractEventTestCase
{
    protected function getEvent(): Event
    {
        return AddPaymentInfoEvent::create()
            ->withCurrency('USD')
            ->withValue(123.45)
            ->withCoupon('WINTER_SALE')
            ->withPaymentType('Credit card')
            ->withItem(Item::create()->withId('SKU1234')->withName('Blue t-shirt'))
        ;
    }

    protected function getExpectedJson(): string
    {
        return '{"name":"add_payment_info","params":{"payment_type":"Credit card","currency":"USD","items":[{"item_id":"SKU1234","item_name":"Blue t-shirt","quantity":1}],"value":123.45,"coupon":"WINTER_SALE"}}';
    }
}
