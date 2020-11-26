<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

use PHPUnit\Framework\TestCase;

final class SelectPromotionEventTest extends TestCase
{
    /**
     * @test
     */
    public function it_returns_array(): void
    {
        $event = new SelectPromotionEvent();
        $event->parameters->locationId = 'L_12345';

        $item = new GenericItemEventParameters();
        $item->itemId = 'SKU_12345';

        $event->parameters->addItem($item);

        self::assertSame([
            'name' => 'select_promotion',
            'params' => ['location_id' => 'L_12345', 'items' => [['item_id' => 'SKU_12345']]],
        ], $event->toArray());
    }
}
