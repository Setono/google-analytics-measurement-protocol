<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event;

use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Item\Item;

/**
 * @covers \Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\AddToCartEvent
 */
final class AddToCartEventTest extends AbstractEventTestCase
{
    protected function getEvent(): Event
    {
        return AddToCartEvent::create()
            ->withCurrency('USD')
            ->withValue(123.45)
            ->withItem(Item::create()->withId('SKU1234')->withName('Blue t-shirt'))
        ;
    }

    protected function getExpectedJson(): string
    {
        return '{"name":"add_to_cart","params":{"currency":"USD","items":[{"item_id":"SKU1234","item_name":"Blue t-shirt","quantity":1}],"value":123.45}}';
    }
}
