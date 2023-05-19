<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event;

use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Item\Item;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Traits\CreatesEmpty;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Traits\HasCurrency;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Traits\HasItems;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Traits\HasValue;

class AddToCartEvent extends Event
{
    use CreatesEmpty;

    use HasCurrency;

    use HasItems;

    use HasValue;

    public function getEventName(): string
    {
        return 'add_to_cart';
    }

    protected function getParameters(): array
    {
        return [
            'currency' => $this->currency,
            'value' => $this->value,
            'items' => array_map(static fn (Item $item) => $item->getParameters(), $this->items),
        ];
    }
}
