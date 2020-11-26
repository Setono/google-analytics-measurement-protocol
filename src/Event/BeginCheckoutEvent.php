<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

/**
 * @property BeginCheckoutEventParameters $parameters
 */
final class BeginCheckoutEvent extends Event
{
    /** This event signifies that a user has begun a checkout. */
    protected string $name = 'begin_checkout';

    public function __construct()
    {
        $this->parameters = new BeginCheckoutEventParameters();
    }
}
