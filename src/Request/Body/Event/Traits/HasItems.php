<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Traits;

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

    /**
     * @return static
     */
    public function addItem(Item $item): self
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * @param list<Item> $items
     *
     * @return static
     */
    public function setItems(array $items): self
    {
        $this->items = $items;

        return $this;
    }
}
