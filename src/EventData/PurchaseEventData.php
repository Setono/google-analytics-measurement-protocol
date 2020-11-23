<?php
declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\EventData;

final class PurchaseEventData extends EventData implements ItemsAwareEventDataInterface
{
    use ItemsAwareEventDataTrait;

    protected string $name = 'purchase';

    public string $affiliation;
    public string $coupon;
    public string $currency;
    public string $transactionId;
    public float $shipping;
    public float $tax;
    public float $value;

    public function toArray(): array
    {
        return [

        ];
    }
}
