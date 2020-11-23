<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

class GenericItemEventParameters extends EventParameters
{
    public string $itemId;

    public string $itemName;

    public string $affiliation;

    public string $coupon;

    public float $discount;

    public string $itemBrand;

    public string $itemCategory;

    public string $itemVariant;

    public float $tax;

    public float $price;

    public string $currency;
}
