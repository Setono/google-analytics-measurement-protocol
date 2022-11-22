<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait;

use Setono\GoogleAnalyticsMeasurementProtocol\Attribute\Serialize;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Event;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Item\Item;

/**
 * @mixin Event
 */
trait HasItems
{
    /** @var list<Item> */
    #[Serialize]
    protected array $items = [];

    /**
     * @return list<Item>
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function withItem(Item $item): self
    {
        $clone = clone $this;
        $clone->items[] = $item;

        return $clone;
    }

    /**
     * @param list<Item> $items
     */
    public function withItems(array $items): self
    {
        return $this->with('items', $items);
    }
}
