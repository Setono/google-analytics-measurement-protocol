<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

final class RemoveFromCartEventParameters extends EventParameters implements ItemsAwareEventParametersInterface
{
    use ItemsAwareEventParametersTrait;

    /**
     * Currency of the items associated with the event, in 3-letter ISO 4217 format.
     * Required: No
     * Example: USD
     */
    public string $currency;

    /**
     * The monetary value of the event.
     * Required: No
     * Example: 7.77
     */
    public float $value;
}
