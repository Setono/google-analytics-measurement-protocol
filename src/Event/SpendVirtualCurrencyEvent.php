<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

/**
 * @property SpendVirtualCurrencyEventParameters $parameters
 */
final class SpendVirtualCurrencyEvent extends Event
{
    /** This event measures the sale of virtual goods in your app and helps you identify which virtual goods are the most popular. */
    protected string $name = 'spend_virtual_currency';

    public function __construct()
    {
        $this->parameters = new SpendVirtualCurrencyEventParameters();
    }
}
