<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

/**
 * @property EarnVirtualCurrencyEventParameters $parameters
 */
final class EarnVirtualCurrencyEvent extends Event
{
    /** This event measures the awarding of virtual currency. Log this along with spend_virtual_currency to better understand your virtual economy. */
    protected string $name = 'earn_virtual_currency';

    public function __construct()
    {
        $this->parameters = new EarnVirtualCurrencyEventParameters();
    }
}
