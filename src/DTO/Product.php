<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\DTO;

use Webmozart\Assert\Assert;

final class Product
{
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

    public function __construct(string $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
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

    /**
     * @return array<string, scalar>
     */
    public function generateData(string $keyPrepend): array
    {
        $tmp = [
            'id' => $this->id,
            'nm' => $this->name,
        ];

        if (null !== $this->brand) {
            $tmp['br'] = $this->brand;
        }

        if (null !== $this->category) {
            $tmp['ca'] = $this->category;
        }

        if (null !== $this->variant) {
            $tmp['va'] = $this->variant;
        }

        if (null !== $this->price) {
            $tmp['pr'] = $this->price;
        }

        if (null !== $this->quantity) {
            $tmp['qt'] = $this->quantity;
        }

        if (null !== $this->couponCode) {
            $tmp['cc'] = $this->couponCode;
        }

        if (null !== $this->position) {
            $tmp['ps'] = $this->position;
        }

        foreach ($this->customDimensions as $idx => $value) {
            $tmp['cd' . $idx] = $value;
        }

        foreach ($this->customMetrics as $idx => $value) {
            $tmp['cm' . $idx] = $value;
        }

        $data = [];

        foreach ($tmp as $key => $val) {
            $data[$keyPrepend . $key] = $val;
        }

        return $data;
    }
}
