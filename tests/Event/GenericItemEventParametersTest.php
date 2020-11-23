<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

use PHPUnit\Framework\TestCase;

final class GenericItemEventParametersTest extends TestCase
{
    /**
     * @test
     */
    public function it_returns_array(): void
    {
        $eventData = new GenericItemEventParameters();
        $eventData->itemId = 'GUCCI_BAG_123';
        $eventData->itemName = 'Gucci bag';
        $eventData->affiliation = 'Web';
        $eventData->coupon = 'SUMMER_SALE';
        $eventData->discount = 10.5;
        $eventData->itemBrand = 'Gucci';
        $eventData->itemCategory = 'Bags';
        $eventData->itemVariant = 'Black';
        $eventData->tax = 9.25;
        $eventData->price = 123.95;
        $eventData->currency = 'USD';

        self::assertSame([
            'item_id' => 'GUCCI_BAG_123',
            'item_name' => 'Gucci bag',
            'affiliation' => 'Web',
            'coupon' => 'SUMMER_SALE',
            'discount' => 10.5,
            'item_brand' => 'Gucci',
            'item_category' => 'Bags',
            'item_variant' => 'Black',
            'tax' => 9.25,
            'price' => 123.95,
            'currency' => 'USD',
        ], $eventData->toArray());
    }
}
