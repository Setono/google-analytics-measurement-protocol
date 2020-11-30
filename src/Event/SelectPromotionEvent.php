<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

/**
 * @property SelectPromotionEventParameters $parameters
 */
final class SelectPromotionEvent extends Event
{
    /** This event signifies an promotion was selected from a list. */
    protected string $name = 'select_promotion';

    public function __construct()
    {
        $this->parameters = new SelectPromotionEventParameters();
    }
}
