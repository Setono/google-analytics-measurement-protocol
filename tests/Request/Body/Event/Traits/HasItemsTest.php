<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Traits;

use PHPUnit\Framework\TestCase;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Item\Item;

final class HasItemsTest extends TestCase
{
    /**
     * @test
     */
    public function it_instantiates(): void
    {
        $obj = new ClassUsingHasItems();
        self::assertEmpty($obj->getItems());
    }

    /**
     * @test
     */
    public function it_is_mutable(): void
    {
        $items = [Item::create()];

        $obj = new ClassUsingHasItems();
        $obj->setItems($items);
        self::assertSame($items, $obj->getItems());

        $obj->addItem(Item::create());
        self::assertCount(2, $obj->getItems());
    }
}

final class ClassUsingHasItems
{
    use HasItems;
}
