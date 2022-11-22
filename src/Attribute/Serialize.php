<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Attribute;

#[\Attribute(\Attribute::TARGET_METHOD | \Attribute::TARGET_PROPERTY)]
final class Serialize
{
    public function __construct(public ?string $name = null)
    {
        if ('' === $this->name) {
            throw new \InvalidArgumentException('The name cannot be empty');
        }
    }
}
