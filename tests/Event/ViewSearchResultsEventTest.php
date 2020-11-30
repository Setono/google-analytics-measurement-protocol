<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

use PHPUnit\Framework\TestCase;

final class ViewSearchResultsEventTest extends TestCase
{
    /**
     * @test
     */
    public function it_returns_array(): void
    {
        $event = new ViewSearchResultsEvent();
        $event->parameters->searchTerm = 'Clothing';

        $item = new GenericItemEventParameters();
        $item->itemId = 'SKU_12345';

        $event->parameters->addItem($item);

        self::assertSame([
            'name' => 'view_search_results',
            'params' => ['search_term' => 'Clothing', 'items' => [['item_id' => 'SKU_12345']]],
        ], $event->toArray());
    }
}
