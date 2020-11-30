<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

use PHPUnit\Framework\TestCase;

final class SelectItemEventTest extends TestCase
{
    /**
     * @test
     */
    public function it_returns_array(): void
    {
        $event = new SelectItemEvent();
        $event->parameters->itemListName = 'Related products';
        $event->parameters->itemListId = 'related_products';

        $item = new GenericItemEventParameters();
        $item->itemId = 'SKU_12345';

        $event->parameters->addItem($item);

        self::assertSame([
            'name' => 'select_item',
            'params' => [
                'item_list_name' => 'Related products',
                'item_list_id' => 'related_products',
                'items' => [['item_id' => 'SKU_12345']],
            ],
        ], $event->toArray());
    }
}
