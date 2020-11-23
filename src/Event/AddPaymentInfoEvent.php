<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

/**
 * @property AddPaymentInfoEventParameters $parameters
 */
final class AddPaymentInfoEvent extends Event
{
    protected string $name = 'add_payment_info';

    public function __construct()
    {
        $this->parameters = new AddPaymentInfoEventParameters();
    }
}
