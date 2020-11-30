<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

use PHPUnit\Framework\TestCase;

final class ViewPromotionEventTest extends TestCase
{
    /**
     * @test
     */
    public function it_returns_array(): void
    {
        $event = new ViewPromotionEvent();
        $event->parameters->locationId = 'L_12345';

        $item = new GenericItemEventParameters();
        $item->itemId = 'SKU_12345';

        $event->parameters->addItem($item);

        self::assertSame([
            'name' => 'view_promotion',
            'params' => ['location_id' => 'L_12345', 'items' => [['item_id' => 'SKU_12345']]],
        ], $event->toArray());
    }
}
