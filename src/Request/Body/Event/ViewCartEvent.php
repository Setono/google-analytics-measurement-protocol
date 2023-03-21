<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event;

use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Item\Item;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait\CreatesEmpty;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait\HasCurrency;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait\HasItems;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait\HasValue;

class ViewCartEvent extends Event
{
    use CreatesEmpty;
    use HasCurrency;
    use HasValue;
    use HasItems;

    public function getEventName(): string
    {
        return 'view_cart';
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
