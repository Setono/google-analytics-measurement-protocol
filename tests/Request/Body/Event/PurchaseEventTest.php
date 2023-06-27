<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event;

use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Item\Item;

/**
 * @covers \Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\PurchaseEvent
 */
final class PurchaseEventTest extends AbstractEventTestCase
{
    protected function getEvent(): Event
    {
        return PurchaseEvent::create('TRANS_1234')
            ->setCurrency('USD')
            ->setValue(123.45)
            ->setTax(10.45)
            ->setShipping(3.32)
            ->addItem(Item::create()->setId('SKU1234')->setName('Blue t-shirt'))
        ;
    }

    protected function getExpectedServerSideJson(): string
    {
        return '{"name":"purchase","params":{"currency":"USD","transaction_id":"TRANS_1234","value":123.45,"shipping":3.32,"tax":10.45,"items":[{"item_id":"SKU1234","item_name":"Blue t-shirt","quantity":1}]}}';
    }

    protected function getExpectedClientSideJson(): string
    {
        return '{"currency":"USD","transaction_id":"TRANS_1234","value":123.45,"shipping":3.32,"tax":10.45,"items":[{"item_id":"SKU1234","item_name":"Blue t-shirt","quantity":1}]}';
    }

    protected function getExpectedClientSideTagManagerJson(): string
    {
        return '{"event":"purchase","ecommerce":{"currency":"USD","transaction_id":"TRANS_1234","value":123.45,"shipping":3.32,"tax":10.45,"items":[{"item_id":"SKU1234","item_name":"Blue t-shirt","quantity":1}]}}';
    }
}
