<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Builder;

use function Safe\sprintf;
use Setono\GoogleAnalyticsMeasurementProtocol\Hit\Payload;
use Webmozart\Assert\Assert;

/**
 * This product builder represents a product in the enhanced ecommerce section.
 *
 * See https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#pr_id
 *
 * @method string|null getSku()
 * @method self setSku(string $sku)
 * @method string|null getName()
 * @method self setName(string $name)
 * @method string|null getBrand()
 * @method self setBrand(string $brand)
 * @method string|null getCategory()
 * @method self setCategory(string $category)
 * @method string|null getVariant()
 * @method self setVariant(string $variant)
 * @method float|null getPrice()
 * @method self setPrice(float $price)
 * @method int|null getQuantity()
 * @method self setQuantity(int $quantity)
 * @method string|null getCouponCode()
 * @method self setCouponCode(string $couponCode)
 * @method int|null getPosition()
 * @method self setPosition(int $position)
 */
final class ProductBuilder extends PayloadBuilder
{
    private static int $indexCounter = 0;

    public int $index;

    /** @var array<int, string> */
    private array $customDimensions = [];

    /** @var array<int, int> */
    private array $customMetrics = [];

    public function __construct(int $index = null)
    {
        ++self::$indexCounter;

        if (null === $index) {
            $index = self::$indexCounter;
        }

        Assert::greaterThanEq($index, 1);
        Assert::lessThanEq($index, 200);

        $this->index = self::$indexCounter = $index;
    }

    public function getPayload(): Payload
    {
        $payload = $this->buildPayload(/** @param scalar $value */function (Payload $payload, string $parameter, $value): void {
            $payload->set(sprintf('pr%d%s', $this->index, $parameter), $value);
        });

        foreach ($this->customDimensions as $dimension => $value) {
            $payload->set(sprintf('pr%dcd%d', $this->index, $dimension), $value);
        }

        foreach ($this->customMetrics as $metric => $value) {
            $payload->set(sprintf('pr%dcm%d', $this->index, $metric), $value);
        }

        return $payload;
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
