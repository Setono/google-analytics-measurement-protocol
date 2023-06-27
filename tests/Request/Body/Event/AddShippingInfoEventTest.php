<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event;

use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Item\Item;

/**
 * @covers \Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\AddShippingInfoEvent
 */
final class AddShippingInfoEventTest extends AbstractEventTestCase
{
    protected function getEvent(): Event
    {
        return AddShippingInfoEvent::create()
            ->setCurrency('USD')
            ->setValue(123.45)
            ->setCoupon('WINTER_SALE')
            ->setShippingTier('EXPENSIVE')
            ->addItem(Item::create()->setId('SKU1234')->setName('Blue t-shirt'))
        ;
    }

    protected function getExpectedServerSideJson(): string
    {
        return '{"name":"add_shipping_info","params":{"currency":"USD","value":123.45,"coupon":"WINTER_SALE","shipping_tier":"EXPENSIVE","items":[{"item_id":"SKU1234","item_name":"Blue t-shirt","quantity":1}]}}';
    }

    protected function getExpectedClientSideJson(): string
    {
        return '{"currency":"USD","value":123.45,"coupon":"WINTER_SALE","shipping_tier":"EXPENSIVE","items":[{"item_id":"SKU1234","item_name":"Blue t-shirt","quantity":1}]}';
    }

    protected function getExpectedClientSideTagManagerJson(): string
    {
        return '{"event":"add_shipping_info","ecommerce":{"currency":"USD","value":123.45,"coupon":"WINTER_SALE","shipping_tier":"EXPENSIVE","items":[{"item_id":"SKU1234","item_name":"Blue t-shirt","quantity":1}]}}';
    }
}
