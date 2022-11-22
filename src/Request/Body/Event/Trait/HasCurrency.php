<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait;

use Setono\GoogleAnalyticsMeasurementProtocol\Attribute\Serialize;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Event;

/**
 * @mixin Event
 */
trait HasCurrency
{
    #[Serialize]
    protected ?string $currency = null;

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function withCurrency(?string $currency): self
    {
        return $this->with('currency', $currency);
    }
}
