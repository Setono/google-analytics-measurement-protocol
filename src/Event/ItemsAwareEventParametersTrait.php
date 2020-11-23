<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

trait ItemsAwareEventParametersTrait
{
    /** @var GenericItemEventParameters[] */
    public array $items = [];

    public function addItem(GenericItemEventParameters $item): void
    {
        $this->items[] = $item;
    }
}
