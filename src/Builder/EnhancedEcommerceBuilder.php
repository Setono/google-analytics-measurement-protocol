<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Builder;

use function Safe\sprintf;

final class EnhancedEcommerceBuilder extends Builder
{
    public string $productAction;

    public string $transactionId;

    public string $transactionAffiliation;

    public float $transactionRevenue;

    public float $transactionShipping;

    public float $transactionTax;

    public string $transactionCouponCode;

    public int $checkoutStep;

    public string $checkoutStepOption;

    public string $currencyCode;

    /** @var ProductBuilder[] */
    public array $products = [];

    public function getQuery(): string
    {
        $mapping = [
            'pa' => 'productAction',
            'ti' => 'transactionId',
            'ta' => 'transactionAffiliation',
            'tr' => 'transactionRevenue',
            'ts' => 'transactionShipping',
            'tt' => 'transactionTax',
            'tcc' => 'transactionCouponCode',
            'cos' => 'checkoutStep',
            'col' => 'checkoutStepOption',
            'cu' => 'currencyCode',
        ];

        $q = $this->buildQuery($mapping, function (string $parameter, string $value): string {
            return sprintf('%s=%s&', $parameter, $value);
        });

        foreach ($this->products as $product) {
            $q .= $product->getQuery() . '&';
        }

        return rtrim($q, '&');
    }

    public function addProduct(ProductBuilder $productBuilder): void
    {
        $this->products[] = $productBuilder;
    }
}
