<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Traits;

trait HasValue
{
    protected ?float $value = null;

    public function getValue(): ?float
    {
        return $this->value;
    }

    /**
     * @return static
     */
    public function setValue(?float $value): self
    {
        $this->value = $value;

        return $this;
    }
}
