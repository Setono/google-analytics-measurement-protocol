<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait;

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
        $obj->setItems([Item::create()]);
        self::assertSame($items, $obj->getItems());
    }
}

final class ClassUsingHasItems
{
    use HasItems;
}
