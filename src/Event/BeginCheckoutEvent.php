<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

/**
 * @property BeginCheckoutEventParameters $parameters
 */
final class BeginCheckoutEvent extends Event
{
    protected string $name = 'begin_checkout';

    public function __construct()
    {
        $this->parameters = new PurchaseEventParameters();
    }
}
