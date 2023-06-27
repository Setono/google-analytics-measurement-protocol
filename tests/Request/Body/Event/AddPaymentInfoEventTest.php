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
            ->setCurrency('USD')
            ->setValue(123.45)
            ->setCoupon('WINTER_SALE')
            ->setPaymentType('Credit card')
            ->addItem(Item::create()->setId('SKU1234')->setName('Blue t-shirt'))
        ;
    }

    protected function getExpectedServerSideJson(): string
    {
        return '{"name":"add_payment_info","params":{"currency":"USD","value":123.45,"coupon":"WINTER_SALE","payment_type":"Credit card","items":[{"item_id":"SKU1234","item_name":"Blue t-shirt","quantity":1}]}}';
    }

    protected function getExpectedClientSideJson(): string
    {
        return '{"currency":"USD","value":123.45,"coupon":"WINTER_SALE","payment_type":"Credit card","items":[{"item_id":"SKU1234","item_name":"Blue t-shirt","quantity":1}]}';
    }

    protected function getExpectedClientSideTagManagerJson(): string
    {
        return '{"event":"add_payment_info","ecommerce":{"currency":"USD","value":123.45,"coupon":"WINTER_SALE","payment_type":"Credit card","items":[{"item_id":"SKU1234","item_name":"Blue t-shirt","quantity":1}]}}';
    }
}
