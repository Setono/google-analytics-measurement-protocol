<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event;

use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Item\Item;

/**
 * @covers \Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\BeginCheckoutEvent
 */
final class BeginCheckoutEventTest extends AbstractEventTestCase
{
    protected function getEvent(): Event
    {
        return BeginCheckoutEvent::create()
            ->setCurrency('USD')
            ->setValue(123.45)
            ->setCoupon('SUMMER_SALE')
            ->addItem(Item::create()->setId('SKU1234')->setName('Blue t-shirt'))
        ;
    }

    protected function getExpectedJson(): string
    {
        return '{"name":"begin_checkout","params":{"currency":"USD","value":123.45,"coupon":"SUMMER_SALE","items":[{"item_id":"SKU1234","item_name":"Blue t-shirt","quantity":1}]}}';
    }
}
