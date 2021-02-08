<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Builder;

use function Safe\sprintf;
use Setono\GoogleAnalyticsMeasurementProtocol\Hit\Payload;

/**
 * This product builder represents a product in the enhanced ecommerce section.
 *
 * See https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#pr_id
 *
 * @method string getSku()
 * @method self setSku(string $sku)
 * @method string getName()
 * @method self setName(string $name)
 * @method string getBrand()
 * @method self setBrand(string $brand)
 * @method string getCategory()
 * @method self setCategory(string $category)
 * @method string getVariant()
 * @method self setVariant(string $variant)
 * @method float getPrice()
 * @method self setPrice(float $price)
 * @method int getQuantity()
 * @method self setQuantity(int $quantity)
 * @method string getCouponCode()
 * @method self setCouponCode(string $couponCode)
 * @method int getPosition()
 * @method self setPosition(int $position)
 */
final class ProductBuilder extends PayloadBuilder
{
    private static int $indexCounter = 1;

    public int $index;

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
