<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

use PHPUnit\Framework\TestCase;

class AddToWishlistEventTest extends TestCase
{
    /**
     * @test
     */
    public function it_returns_array(): void
    {
        $event = new AddToWishlistEvent();
        $event->parameters->currency = 'USD';
        $event->parameters->value = 123.95;

        $item = new GenericItemEventParameters();
        $item->itemId = 'GUCCI_BAG_1234';

        $event->parameters->addItem($item);

        self::assertSame([
            'name' => 'add_to_wishlist',
            'params' => [
                'currency' => 'USD',
                'value' => 123.95,
                'items' => [
                    ['item_id' => 'GUCCI_BAG_1234'],
                ],
            ],
        ], $event->toArray());
    }
}
