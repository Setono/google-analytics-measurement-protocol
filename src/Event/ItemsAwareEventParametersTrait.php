<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

trait ItemsAwareEventParametersTrait
{
    /** @var ItemEventParameters[] */
    public array $items = [];

    public function addItem(ItemEventParameters $item): void
    {
        $this->items[] = $item;
    }
}
