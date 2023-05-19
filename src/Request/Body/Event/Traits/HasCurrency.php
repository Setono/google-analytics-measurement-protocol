<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Traits;

trait HasCurrency
{
    protected ?string $currency = null;

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /**
     * @return static
     */
    public function setCurrency(?string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }
}
