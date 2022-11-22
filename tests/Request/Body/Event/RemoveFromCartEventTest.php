<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event;

use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Item\Item;

/**
 * @covers \Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\RemoveFromCartEvent
 */
final class RemoveFromCartEventTest extends AbstractEventTestCase
{
    protected function getEvent(): Event
    {
        return RemoveFromCartEvent::create()
            ->setCurrency('USD')
            ->setValue(123.45)
            ->addItem(Item::create()->setId('SKU1234')->setName('Blue t-shirt'))
        ;
    }

    protected function getExpectedJson(): string
    {
        return '{"name":"remove_from_cart","params":{"currency":"USD","items":[{"item_id":"SKU1234","item_name":"Blue t-shirt","quantity":1}],"value":123.45}}';
    }
}
