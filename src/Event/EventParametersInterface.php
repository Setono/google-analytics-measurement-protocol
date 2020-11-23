<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

interface EventParametersInterface
{
    public function toArray(): array;
}
