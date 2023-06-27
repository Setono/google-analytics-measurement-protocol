<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event;

use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Item\Item;

/**
 * @covers \Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\ViewItemListEvent
 */
final class ViewItemListEventTest extends AbstractEventTestCase
{
    protected function getEvent(): Event
    {
        return ViewItemListEvent::create()
            ->setListId('LIST_ID')
            ->setListName('List name')
            ->addItem(Item::create()->setId('SKU1234')->setName('Blue t-shirt'))
        ;
    }

    protected function getExpectedServerSideJson(): string
    {
        return '{"name":"view_item_list","params":{"item_list_id":"LIST_ID","item_list_name":"List name","items":[{"item_id":"SKU1234","item_name":"Blue t-shirt","quantity":1}]}}';
    }

    protected function getExpectedClientSideJson(): string
    {
        return '{"item_list_id":"LIST_ID","item_list_name":"List name","items":[{"item_id":"SKU1234","item_name":"Blue t-shirt","quantity":1}]}';
    }

    protected function getExpectedClientSideTagManagerJson(): string
    {
        return '{"event":"view_item_list","ecommerce":{"item_list_id":"LIST_ID","item_list_name":"List name","items":[{"item_id":"SKU1234","item_name":"Blue t-shirt","quantity":1}]}}';
    }
}
