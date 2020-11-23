<?php
declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\EventData;

trait ItemsAwareEventDataTrait
{
    /** @var ItemEventData[] */
    private array $items = [];

    public function addItem(ItemEventData $item): void
    {
        $this->items[] = $item;
    }
}
