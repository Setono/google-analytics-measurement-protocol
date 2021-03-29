<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\DTO\Event;

use Setono\GoogleAnalyticsMeasurementProtocol\DTO\DTOInterface;
use Setono\GoogleAnalyticsMeasurementProtocol\DTO\Product;
use Setono\GoogleAnalyticsMeasurementProtocol\Hit\HitBuilder;

final class PurchaseEvent implements DTOInterface
{
    public string $transactionId;

    public string $affiliation;

    public float $value;

    public string $currency;

    public float $tax;

    public float $shipping;

    /** @var array<array-key, Product> */
    public array $products;

    /**
     * @param array<array-key, Product> $products
     */
    public function __construct(
        string $transactionId,
        string $affiliation,
        float $value,
        string $currency,
        float $tax,
        float $shipping,
        array $products = []
    ) {
        $this->transactionId = $transactionId;
        $this->affiliation = $affiliation;
        $this->value = $value;
        $this->currency = $currency;
        $this->tax = $tax;
        $this->shipping = $shipping;
        $this->products = $products;
    }

    public function applyTo(HitBuilder $hitBuilder): void
    {
        $hitBuilder
            ->setProductAction('purchase')
            ->setTransactionId($this->transactionId)
            ->setTransactionAffiliation($this->affiliation)
            ->setTransactionRevenue($this->value)
            ->setCurrencyCode($this->currency)
            ->setTransactionTax($this->tax)
            ->setTransactionShipping($this->shipping)
        ;

        foreach ($this->products as $product) {
            $product->applyTo($hitBuilder);
        }
    }
}
