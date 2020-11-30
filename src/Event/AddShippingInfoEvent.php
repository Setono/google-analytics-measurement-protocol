<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

/**
 * @property AddShippingInfoEventParameters $parameters
 */
final class AddShippingInfoEvent extends Event
{
    /** This event signifies a user has submitted their shipping information. */
    protected string $name = 'add_shipping_info';

    public function __construct()
    {
        $this->parameters = new AddShippingInfoEventParameters();
    }
}
