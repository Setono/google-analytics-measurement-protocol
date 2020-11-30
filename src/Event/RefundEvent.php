<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

/**
 * @property RefundEventParameters $parameters
 */
final class RefundEvent extends Event
{
    /** This event signifies a refund was issued. */
    protected string $name = 'refund';

    public function __construct()
    {
        $this->parameters = new RefundEventParameters();
    }
}
