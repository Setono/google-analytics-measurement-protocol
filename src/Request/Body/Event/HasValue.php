<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event;

/**
 * @mixin Event
 */
trait HasValue
{
    protected ?float $value = null;

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function withValue(?float $value): self
    {
        return $this->with('value', $value);
    }
}
