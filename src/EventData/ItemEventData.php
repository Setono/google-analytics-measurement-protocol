<?php
declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\EventData;

final class ItemEventData extends EventData
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
