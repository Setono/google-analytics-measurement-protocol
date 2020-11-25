<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

/**
 * @property AddToWishlistEventParameters $parameters
 */
final class AddToWishlistEvent extends Event
{
    protected string $name = 'add_to_wishlist';

    public function __construct()
    {
        $this->parameters = new AddToWishlistEventParameters();
    }
}
