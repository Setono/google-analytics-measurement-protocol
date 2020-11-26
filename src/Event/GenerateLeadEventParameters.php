<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

final class GenerateLeadEventParameters extends EventParameters
{
    /**
     * The currency of the lead, in 3-letter ISO 4217 format.
     * Required: No
     * Example: USD
     */
    public string $currency;

    /**
     * The value of the lead.
     * Required: No
     * Example: 99.99
     */
    public float $value;
}
