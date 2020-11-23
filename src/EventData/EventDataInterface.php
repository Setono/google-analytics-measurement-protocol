<?php
declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\EventData;

interface EventDataInterface
{
    public function toArray(): array;
}
