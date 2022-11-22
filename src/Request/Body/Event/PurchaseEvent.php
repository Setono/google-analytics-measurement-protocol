<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event;

class PurchaseEvent extends Event
{
    use HasCurrency;
    use HasItems;
    use HasValue;
    use HasCoupon;

    private string $transactionId;

    private ?string $affiliation = null;

    private ?float $shipping = null;

    private ?float $tax = null;

    private function __construct(string $transactionId)
    {
        $this->transactionId = $transactionId;
    }

    public static function create(string $transactionId): self
    {
        return new self($transactionId);
    }

    protected function getName(): string
    {
        return 'purchase';
    }

    protected function getData(): array
    {
        return [
            'transaction_id' => $this->transactionId,
            'currency' => $this->currency,
            'value' => $this->value,
            'affiliation' => $this->affiliation,
            'coupon' => $this->coupon,
            'shipping' => $this->shipping,
            'tax' => $this->tax,
            'items' => $this->items,
        ];
    }

    public function getTransactionId(): string
    {
        return $this->transactionId;
    }

    public function withTransactionId(string $transactionId): self
    {
        return $this->with('transactionId', $transactionId);
    }

    public function getAffiliation(): ?string
    {
        return $this->affiliation;
    }

    public function withAffiliation(string $affiliation): self
    {
        return $this->with('affiliation', $affiliation);
    }

    public function getShipping(): ?float
    {
        return $this->shipping;
    }

    public function withShipping(string $shipping): self
    {
        return $this->with('shipping', $shipping);
    }

    public function getTax(): ?float
    {
        return $this->tax;
    }

    public function withTax(string $tax): self
    {
        return $this->with('tax', $tax);
    }
}
