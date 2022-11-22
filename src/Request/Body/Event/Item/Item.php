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
use Setono\GoogleAnalyticsMeasurementProtocol\Request\HasWithers;

class Item implements JsonSerializable
{
    use CreatesEmpty;
    use HasWithers;
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

    public function withId(?string $id): self
    {
        return $this->with('id', $id);
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function withName(?string $name): self
    {
        return $this->with('name', $name);
    }

    public function getDiscount(): ?float
    {
        return $this->discount;
    }

    public function withDiscount(?float $discount): self
    {
        return $this->with('discount', $discount);
    }

    public function getIndex(): ?int
    {
        return $this->index;
    }

    public function withIndex(?int $index): self
    {
        return $this->with('index', $index);
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function withBrand(?string $brand): self
    {
        return $this->with('brand', $brand);
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function withCategory(?string $category): self
    {
        return $this->with('category', $category);
    }

    public function getCategory2(): ?string
    {
        return $this->category2;
    }

    public function withCategory2(?string $category2): self
    {
        return $this->with('category2', $category2);
    }

    public function getCategory3(): ?string
    {
        return $this->category3;
    }

    public function withCategory3(?string $category3): self
    {
        return $this->with('category3', $category3);
    }

    public function getCategory4(): ?string
    {
        return $this->category4;
    }

    public function withCategory4(?string $category4): self
    {
        return $this->with('category4', $category4);
    }

    public function getCategory5(): ?string
    {
        return $this->category5;
    }

    public function withCategory5(?string $category5): self
    {
        return $this->with('category5', $category5);
    }

    public function getVariant(): ?string
    {
        return $this->variant;
    }

    public function withVariant(?string $variant): self
    {
        return $this->with('variant', $variant);
    }

    public function getLocationId(): ?string
    {
        return $this->locationId;
    }

    public function withLocationId(?string $locationId): self
    {
        return $this->with('locationId', $locationId);
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function withPrice(?float $price): self
    {
        return $this->with('price', $price);
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function withQuantity(int $quantity): self
    {
        return $this->with('quantity', $quantity);
    }
}
