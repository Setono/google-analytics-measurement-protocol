<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait;

trait CreatesEmpty
{
    public static function create(): self
    {
        return new self();
    }
}
