<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Builder;

use function Safe\sprintf;

/**
 * This product builder represents a product in the enhanced ecommerce section.
 *
 * See https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#pr_id
 */
final class ProductBuilder extends Builder
{
    private static int $indexCounter = 1;

    public int $index;

    public string $sku;

    public string $name;

    public string $brand;

    public string $category;

    public string $variant;

    public float $price;

    public int $quantity;

    public string $couponCode;

    public int $position;

    /** @var array<int, string> */
    private array $customDimensions = [];

    /** @var array<int, int> */
    private array $customMetrics = [];

    public function __construct(int $index = null)
    {
        if (null === $index) {
            $index = self::$indexCounter;
        }

        self::$indexCounter = $index + 1;

        $this->index = $index;
    }

    public function getQuery(): string
    {
        $q = $this->buildQuery($this->getPropertyMapping(), function (string $parameter, string $value): string {
            return sprintf('pr%d%s=%s&', $this->index, $parameter, $value);
        });

        foreach ($this->customDimensions as $dimension => $value) {
            $q .= sprintf('pr%dcd%d=%s&', $this->index, $dimension, $value);
        }

        foreach ($this->customMetrics as $metric => $value) {
            $q .= sprintf('pr%dcm%d=%d&', $this->index, $metric, $value);
        }

        return rtrim($q, '&');
    }

    public function setCustomDimension(int $index, string $value): void
    {
        $this->customDimensions[$index] = $value;
    }

    public function setCustomMetric(int $index, int $value): void
    {
        $this->customMetrics[$index] = $value;
    }

    protected function getPropertyMapping(): array
    {
        return [
            'id' => 'sku',
            'nm' => 'name',
            'br' => 'brand',
            'ca' => 'category',
            'va' => 'variant',
            'pr' => 'price',
            'qt' => 'quantity',
            'cc' => 'couponCode',
            'ps' => 'position',
        ];
    }
}
