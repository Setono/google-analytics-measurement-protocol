<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Item;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Item\Item
 */
final class ItemTest extends TestCase
{
    /**
     * @test
     */
    public function it_serializes(): void
    {
        self::assertSame(
            '{"item_id":"SKU1234","item_name":"Blue t-shirt","discount":2.22,"item_brand":"Google","item_category":"Apparel","item_category2":"Adult","item_category3":"Shirts","item_category4":"Crew","item_category5":"Short sleeve","item_variant":"green","location_id":"ChIJIQBpAG2ahYAR_6128GcTUEo","price":9.99,"quantity":1,"affiliation":"Google Merchandise Store","coupon":"SUMMER_FUN","currency":"USD","item_list_id":"related_products","item_list_name":"Related Products"}',
            json_encode($this->getItem()),
        );
    }

    /**
     * @test
     */
    public function it_has_working_getters(): void
    {
        $item = $this->getItem();

        self::assertSame('SKU1234', $item->getId());
        self::assertSame('Blue t-shirt', $item->getName());
        self::assertSame('Google Merchandise Store', $item->getAffiliation());
        self::assertSame('SUMMER_FUN', $item->getCoupon());
        self::assertSame('USD', $item->getCurrency());
        self::assertSame(2.22, $item->getDiscount());
        self::assertSame(0, $item->getIndex());
        self::assertSame('Google', $item->getBrand());
        self::assertSame('Apparel', $item->getCategory());
        self::assertSame('Adult', $item->getCategory2());
        self::assertSame('Shirts', $item->getCategory3());
        self::assertSame('Crew', $item->getCategory4());
        self::assertSame('Short sleeve', $item->getCategory5());
        self::assertSame('related_products', $item->getListId());
        self::assertSame('Related Products', $item->getListName());
        self::assertSame('green', $item->getVariant());
        self::assertSame('ChIJIQBpAG2ahYAR_6128GcTUEo', $item->getLocationId());
        self::assertSame(9.99, $item->getPrice());
        self::assertSame(1, $item->getQuantity());
    }

    private function getItem(): Item
    {
        return Item::create()
            ->withId('SKU1234')
            ->withName('Blue t-shirt')
            ->withAffiliation('Google Merchandise Store')
            ->withCoupon('SUMMER_FUN')
            ->withCurrency('USD')
            ->withDiscount(2.22)
            ->withIndex(0)
            ->withBrand('Google')
            ->withCategory('Apparel')
            ->withCategory2('Adult')
            ->withCategory3('Shirts')
            ->withCategory4('Crew')
            ->withCategory5('Short sleeve')
            ->withListId('related_products')
            ->withListName('Related Products')
            ->withVariant('green')
            ->withLocationId('ChIJIQBpAG2ahYAR_6128GcTUEo')
            ->withPrice(9.99)
            ->withQuantity(1)
        ;
    }
}
