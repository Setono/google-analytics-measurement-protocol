<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Traits;

trait CreatesEmpty
{
    public static function create(): self
    {
        return new self();
    }
}
