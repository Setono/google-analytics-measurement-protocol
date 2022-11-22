<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request;

trait HasSetters
{
    /**
     * @param string $property The property to change on the new cloned object
     * @param mixed $value The value for the property on the new cloned object
     */
    protected function set(string $property, mixed $value): static
    {
        $this->{$property} = $value;

        return $this;
    }
}
