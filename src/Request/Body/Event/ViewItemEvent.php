<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event;

class ViewItemEvent extends Event
{
    use CreatesEmpty;
    use HasCurrency;
    use HasItems;
    use HasValue;

    protected function getName(): string
    {
        return 'view_item';
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
