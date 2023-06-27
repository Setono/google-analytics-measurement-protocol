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
            ->setCurrency('USD')
            ->setValue(123.45)
            ->addItem(Item::create()->setId('SKU1234')->setName('Blue t-shirt'))
        ;
    }

    protected function getExpectedServerSideJson(): string
    {
        return '{"name":"add_to_cart","params":{"currency":"USD","value":123.45,"items":[{"item_id":"SKU1234","item_name":"Blue t-shirt","quantity":1}]}}';
    }

    protected function getExpectedClientSideJson(): string
    {
        return '{"currency":"USD","value":123.45,"items":[{"item_id":"SKU1234","item_name":"Blue t-shirt","quantity":1}]}';
    }

    protected function getExpectedClientSideTagManagerJson(): string
    {
        return '{"event":"add_to_cart","ecommerce":{"currency":"USD","value":123.45,"items":[{"item_id":"SKU1234","item_name":"Blue t-shirt","quantity":1}]}}';
    }
}
