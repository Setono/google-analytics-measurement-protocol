<?php
declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\EventData;

interface ItemsAwareEventDataInterface extends EventDataInterface
{
    public function addItem(): void;
}
