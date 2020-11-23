<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

/**
 * @property AddToCartEventParameters $parameters
 */
final class AddToCartEvent extends Event
{
    protected string $name = 'add_to_cart';

    public function __construct()
    {
        $this->parameters = new AddToCartEventParameters();
    }
}
