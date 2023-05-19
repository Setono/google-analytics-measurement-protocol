<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Item;

use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Traits\CreatesEmpty;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Traits\HasAffiliation;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Traits\HasCoupon;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Traits\HasCurrency;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Traits\HasListId;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Traits\HasListName;

class Item
{
    use CreatesEmpty;

    use HasAffiliation;

    use HasCoupon;

    use HasCurrency;

    use HasListId;

    use HasListName;

    protected ?string $id = null;

    protected ?string $name = null;

    protected ?float $discount = null;

    protected ?int $index = null;

    protected ?string $brand = null;

    protected ?string $category = null;

    protected ?string $category2 = null;

    protected ?string $category3 = null;

    protected ?string $category4 = null;

    protected ?string $category5 = null;

    protected ?string $variant = null;

    protected ?string $locationId = null;

    protected ?float $price = null;

    protected int $quantity = 1;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDiscount(): ?float
    {
        return $this->discount;
    }

    public function setDiscount(?float $discount): self
    {
        $this->discount = $discount;

        return $this;
    }

    public function getIndex(): ?int
    {
        return $this->index;
    }

    public function setIndex(?int $index): self
    {
        $this->index = $index;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(?string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getCategory2(): ?string
    {
        return $this->category2;
    }

    public function setCategory2(?string $category2): self
    {
        $this->category2 = $category2;

        return $this;
    }

    public function getCategory3(): ?string
    {
        return $this->category3;
    }

    public function setCategory3(?string $category3): self
    {
        $this->category3 = $category3;

        return $this;
    }

    public function getCategory4(): ?string
    {
        return $this->category4;
    }

    public function setCategory4(?string $category4): self
    {
        $this->category4 = $category4;

        return $this;
    }

    public function getCategory5(): ?string
    {
        return $this->category5;
    }

    public function setCategory5(?string $category5): self
    {
        $this->category5 = $category5;

        return $this;
    }

    public function getVariant(): ?string
    {
        return $this->variant;
    }

    public function setVariant(?string $variant): self
    {
        $this->variant = $variant;

        return $this;
    }

    public function getLocationId(): ?string
    {
        return $this->locationId;
    }

    public function setLocationId(?string $locationId): self
    {
        $this->locationId = $locationId;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getParameters(): array
    {
        return array_filter([
            'item_id' => $this->id,
            'item_name' => $this->name,
            'affiliation' => $this->affiliation,
            'coupon' => $this->coupon,
            'currency' => $this->currency,
            'discount' => $this->discount,
            'index' => $this->index,
            'item_brand' => $this->brand,
            'item_category' => $this->category,
            'item_category2' => $this->category2,
            'item_category3' => $this->category3,
            'item_category4' => $this->category4,
            'item_category5' => $this->category5,
            'item_list_id' => $this->listId,
            'item_list_name' => $this->listName,
            'item_variant' => $this->variant,
            'location_id' => $this->locationId,
            'price' => $this->price,
            'quantity' => $this->quantity,
        ]);
    }
}
