<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

final class AddToWishlistEventParameters extends EventParameters implements ItemsAwareEventParametersInterface
{
    use ItemsAwareEventParametersTrait;

    public string $currency;

    public float $value;
}
