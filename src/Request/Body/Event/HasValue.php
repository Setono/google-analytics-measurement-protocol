<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event;

/**
 * @mixin Event
 */
trait HasValue
{
    private ?float $value = null;

    public function withValue(?float $value): self
    {
        return $this->with('value', $value);
    }
}
