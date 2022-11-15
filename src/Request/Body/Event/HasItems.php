<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event;

use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Item\Item;

/**
 * @mixin Event
 */
trait HasItems
{
    /** @var list<Item> */
    private array $items = [];

    public function addItem(Item $item): self
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * @param list<Item> $items
     */
    public function withItems(array $items): self
    {
        return $this->with('items', $items);
    }
}
