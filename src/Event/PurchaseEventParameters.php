<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

final class PurchaseEventParameters extends EventParameters implements ItemsAwareEventParametersInterface
{
    use ItemsAwareEventParametersTrait;

    /**
     * A product affiliation to designate a supplying company or brick and mortar store location.
     * Required: No
     * Example: Google Store
     */
    public string $affiliation;

    /**
     * Coupon code used for a purchase.
     * Required: No
     * Example: SUMMER_FUN
     */
    public string $coupon;

    /**
     * Currency of the purchase or items associated with the event, in 3-letter ISO 4217 format.
     * Required: No
     * Example: USD
     */
    public string $currency;

    /**
     * The unique identifier of a transaction.
     * Required: No
     * Example: T_12345
     */
    public string $transactionId;

    /**
     * Shipping cost associated with a transaction.
     * Required: No
     * Example: 3.33
     */
    public float $shipping;

    /**
     * Tax cost associated with a transaction.
     * Required: No
     * Example: 1.11
     */
    public float $tax;

    /**
     * The monetary value of the event, in units of the specified currency parameter.
     * Required: No
     * Example: 12.21
     */
    public float $value;
}
