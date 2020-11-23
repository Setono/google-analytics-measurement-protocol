<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

final class AddPaymentInfoEventParameters extends EventParameters implements ItemsAwareEventParametersInterface
{
    use ItemsAwareEventParametersTrait;

    public string $coupon;

    public string $currency;

    public float $value;

    public string $paymentType;
}
