<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event;

use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait\CreatesEmpty;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait\HasCurrency;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait\HasItems;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait\HasValue;

class AddToCartEvent extends Event
{
    use CreatesEmpty;
    use HasCurrency;
    use HasItems;
    use HasValue;

    protected function getEventName(): string
    {
        return 'add_to_cart';
    }

    protected function getData(): array
    {
        return [
            'currency' => $this->currency,
            'value' => $this->value,
            'items' => $this->items,
        ];
    }
}
