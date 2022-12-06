<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request;

trait HasSetters
{
    /**
     * @param string $property The property to change
     * @param mixed $value The value for the property
     */
    protected function set(string $property, mixed $value): static
    {
        $this->{$property} = $value;

        return $this;
    }
}
