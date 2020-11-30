<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

final class EarnVirtualCurrencyEventParameters extends EventParameters
{
    /**
     * The name of the virtual currency.
     * Required: No
     * Example: Gems
     */
    public string $virtualCurrencyName;

    /**
     * The value of the virtual currency.
     * Required: No
     * Example: 5
     */
    public int $value;
}
