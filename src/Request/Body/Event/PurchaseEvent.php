<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event;

use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Item\Item;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Traits\HasAffiliation;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Traits\HasCoupon;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Traits\HasCurrency;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Traits\HasItems;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Traits\HasTransactionId;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Traits\HasValue;

class PurchaseEvent extends Event
{
    public const NAME = 'purchase';

    use HasCurrency;

    use HasItems;

    use HasValue;

    use HasCoupon;

    use HasTransactionId;

    use HasAffiliation;

    protected ?float $shipping = null;

    protected ?float $tax = null;

    public function __construct(string $transactionId)
    {
        $this->transactionId = $transactionId;
    }

    public static function create(string $transactionId): self
    {
        return new self($transactionId);
    }

    public function getEventName(): string
    {
        return self::NAME;
    }

    public function getShipping(): ?float
    {
        return $this->shipping;
    }

    public function setShipping(?float $shipping): self
    {
        $this->shipping = $shipping;

        return $this;
    }

    public function getTax(): ?float
    {
        return $this->tax;
    }

    public function setTax(?float $tax): self
    {
        $this->tax = $tax;

        return $this;
    }

    protected function getParameters(): array
    {
        return [
            'currency' => $this->currency,
            'transaction_id' => $this->transactionId,
            'value' => $this->value,
            'coupon' => $this->coupon,
            'shipping' => $this->shipping,
            'tax' => $this->tax,
            'items' => array_map(static fn (Item $item) => $item->getParameters(), $this->items),
        ];
    }
}
