<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event;

/**
 * @mixin Event
 */
trait HasCurrency
{
    private ?string $currency = null;

    public function withCurrency(?string $currency): self
    {
        return $this->with('currency', $currency);
    }
}
