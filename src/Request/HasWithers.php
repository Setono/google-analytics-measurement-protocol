<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request;

trait HasWithers
{
    /**
     * @param string $property The property to change on the new cloned object
     * @param mixed $value The value for the property on the new cloned object
     */
    protected function with(string $property, mixed $value): static
    {
        $clone = clone $this;
        $clone->{$property} = $value;

        return $clone;
    }
}
