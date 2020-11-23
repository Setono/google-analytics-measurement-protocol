<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

interface ItemsAwareEventParametersInterface extends EventParametersInterface
{
    public function addItem(GenericItemEventParameters $item): void;
}
