<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

interface EventInterface
{
    public function toArray(): array;
}
