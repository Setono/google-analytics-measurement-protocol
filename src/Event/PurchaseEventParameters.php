<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

final class PurchaseEventParameters extends EventParameters implements ItemsAwareEventParametersInterface
{
    use ItemsAwareEventParametersTrait;

    public string $affiliation;

    public string $coupon;

    public string $currency;

    public string $transactionId;

    public float $shipping;

    public float $tax;

    public float $value;
}
