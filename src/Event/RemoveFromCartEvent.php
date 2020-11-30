<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

/**
 * @property RemoveFromCartEventParameters $parameters
 */
final class RemoveFromCartEvent extends Event
{
    /** This event signifies that an item was removed from a cart. */
    protected string $name = 'remove_from_cart';

    public function __construct()
    {
        $this->parameters = new RemoveFromCartEventParameters();
    }
}
