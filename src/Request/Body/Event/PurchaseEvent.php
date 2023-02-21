<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event;

use Setono\GoogleAnalyticsMeasurementProtocol\Attribute\Serialize;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait\HasAffiliation;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait\HasCoupon;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait\HasCurrency;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait\HasItems;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait\HasTransactionId;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait\HasValue;

class PurchaseEvent extends Event
{
    use HasCurrency;
    use HasItems;
    use HasValue;
    use HasCoupon;
    use HasTransactionId;
    use HasAffiliation;

    #[Serialize]
    protected ?float $shipping = null;

    #[Serialize]
    protected ?float $tax = null;

    public function __construct(string $transactionId)
    {
        $this->transactionId = $transactionId;
    }

    public static function create(string $transactionId): self
    {
        return new self($transactionId);
    }

    protected function getEventName(): string
    {
        return 'purchase';
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
}
