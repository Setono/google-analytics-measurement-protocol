<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait;

use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Item\Item;

trait HasItems
{
    /** @var list<Item> */
    protected array $items = [];

    /**
     * @return list<Item>
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function addItem(Item $item): static
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * @param list<Item> $items
     */
    public function setItems(array $items): static
    {
        $this->items = $items;

        return $this;
    }
}
