<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Item;

use JsonSerializable;
use Setono\GoogleAnalyticsMeasurementProtocol\Attribute\Serialize;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait\CreatesEmpty;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait\HasAffiliation;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait\HasCoupon;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait\HasCurrency;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait\HasListId;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait\HasListName;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait\Serializable;

class Item implements JsonSerializable
{
    use CreatesEmpty;
    use HasAffiliation;
    use HasCoupon;
    use HasCurrency;
    use HasListId;
    use HasListName;
    use Serializable;

    #[Serialize(name: 'item_id')]
    protected ?string $id = null;

    #[Serialize(name: 'item_name')]
    protected ?string $name = null;

    #[Serialize]
    protected ?float $discount = null;

    #[Serialize]
    protected ?int $index = null;

    #[Serialize(name: 'item_brand')]
    protected ?string $brand = null;

    #[Serialize(name: 'item_category')]
    protected ?string $category = null;

    #[Serialize(name: 'item_category2')]
    protected ?string $category2 = null;

    #[Serialize(name: 'item_category3')]
    protected ?string $category3 = null;

    #[Serialize(name: 'item_category4')]
    protected ?string $category4 = null;

    #[Serialize(name: 'item_category5')]
    protected ?string $category5 = null;

    #[Serialize(name: 'item_variant')]
    protected ?string $variant = null;

    #[Serialize(name: 'location_id')]
    protected ?string $locationId = null;

    #[Serialize]
    protected ?float $price = null;

    #[Serialize]
    protected int $quantity = 1;

    public function jsonSerialize(): array
    {
        return $this->serialize();
    }

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
}
