<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

final class SpendVirtualCurrencyEventParameters extends EventParameters
{
    /**
     * The name of the item the virtual currency is being used for.
     * Required: No
     * Example: Starter Boost
     */
    public string $itemName;

    /**
     * The name of the virtual currency.
     * Required: Yes
     * Example: Gems
     */
    public string $virtualCurrencyName;

    /**
     * The value of the virtual currency.
     * Required: Yes
     * Example: 5
     */
    public int $value;
}
