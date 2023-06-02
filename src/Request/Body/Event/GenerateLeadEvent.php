<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event;

use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Traits\CreatesEmpty;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Traits\HasCurrency;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Traits\HasValue;

class GenerateLeadEvent extends Event
{
    use CreatesEmpty;

    use HasCurrency;

    use HasValue;

    public function getEventName(): string
    {
        return 'generate_lead';
    }

    protected function getParameters(): array
    {
        return [
            'currency' => $this->currency,
            'value' => $this->value,
        ];
    }
}
