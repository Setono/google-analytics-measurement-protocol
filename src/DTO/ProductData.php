<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\DTO;

use Setono\GoogleAnalyticsMeasurementProtocol\Hit\HitBuilder;
use Webmozart\Assert\Assert;

final class ProductData implements DTOInterface
{
    public const TYPE_PRODUCT = 'product';

    public const TYPE_PRODUCT_IMPRESSION = 'product_impression';

    private static int $productCounter = 0;

    private string $type;

    public int $index;

    public ?int $impressionListIndex = null;

    public string $id;

    public string $name;

    public ?string $variant = null;

    public ?int $quantity = null;

    public ?float $price = null;

    public ?string $category = null;

    public ?string $brand = null;

    public ?int $position = null;

    public ?string $couponCode = null;

    /** @var array<int, string> */
    public array $customDimensions = [];

    /** @var array<int, int> */
    public array $customMetrics = [];

    public function __construct(string $id, string $name, string $type)
    {
        Assert::oneOf($type, [self::TYPE_PRODUCT, self::TYPE_PRODUCT_IMPRESSION]);

        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->index = ++self::$productCounter;
    }

    public static function createAsProductType(string $id, string $name): self
    {
        return new self($id, $name, self::TYPE_PRODUCT);
    }

    public static function createAsProductImpressionType(string $id, string $name, int $impressionListIndex): self
    {
        $obj = new self($id, $name, self::TYPE_PRODUCT_IMPRESSION);
        $obj->impressionListIndex = $impressionListIndex;

        return $obj;
    }

    public function setCustomDimension(int $index, string $value): void
    {
        Assert::greaterThanEq($index, 1);
        Assert::lessThanEq($index, 200);

        $this->customDimensions[$index] = $value;
    }

    public function setCustomMetric(int $index, int $value): void
    {
        Assert::greaterThanEq($index, 1);
        Assert::lessThanEq($index, 200);

        $this->customMetrics[$index] = $value;
    }

    public function applyTo(HitBuilder $hitBuilder): void
    {
        switch ($this->type) {
            case self::TYPE_PRODUCT:
                $hitBuilder
                    ->setProductSku($this->id, $this->index)
                    ->setProductName($this->name, $this->index)
                    ->setProductBrand($this->brand, $this->index)
                    ->setProductCategory($this->category, $this->index)
                    ->setProductVariant($this->variant, $this->index)
                    ->setProductPrice($this->price, $this->index)
                    ->setProductQuantity($this->quantity, $this->index)
                    ->setProductCouponCode($this->couponCode, $this->index)
                    ->setProductPosition($this->position, $this->index)
                ;

                foreach ($this->customDimensions as $idx => $value) {
                    $hitBuilder->setProductCustomDimension($value, $idx, $this->index);
                }

                foreach ($this->customMetrics as $idx => $value) {
                    $hitBuilder->setProductCustomMetric($value, $idx, $this->index);
                }

                break;
            case self::TYPE_PRODUCT_IMPRESSION:
                Assert::notNull($this->impressionListIndex);

                $hitBuilder
                    ->setProductImpressionSku($this->id, $this->index, $this->impressionListIndex)
                    ->setProductImpressionName($this->name, $this->index, $this->impressionListIndex)
                    ->setProductImpressionBrand($this->brand, $this->index, $this->impressionListIndex)
                    ->setProductImpressionCategory($this->category, $this->index, $this->impressionListIndex)
                    ->setProductImpressionVariant($this->variant, $this->index, $this->impressionListIndex)
                    ->setProductImpressionPrice($this->price, $this->index, $this->impressionListIndex)
                    ->setProductImpressionCouponCode($this->couponCode, $this->index, $this->impressionListIndex)
                    ->setProductImpressionPosition($this->position, $this->index, $this->impressionListIndex)
                ;

                foreach ($this->customDimensions as $idx => $value) {
                    $hitBuilder->setProductImpressionCustomDimension($value, $idx, $this->index, $this->impressionListIndex);
                }

                foreach ($this->customMetrics as $idx => $value) {
                    $hitBuilder->setProductImpressionCustomMetric($value, $idx, $this->index, $this->impressionListIndex);
                }

                break;
        }
    }
}
