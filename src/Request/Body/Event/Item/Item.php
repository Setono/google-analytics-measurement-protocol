<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Item;

use JsonSerializable;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\HasWithers;

final class Item implements JsonSerializable
{
    use HasWithers;

    private ?string $id = null;

    private ?string $name = null;

    private ?string $affiliation = null;

    private ?string $coupon = null;

    private ?string $currency = null;

    private ?float $discount = null;

    private ?int $index = null;

    private ?string $brand = null;

    private ?string $category = null;

    private ?string $category2 = null;

    private ?string $category3 = null;

    private ?string $category4 = null;

    private ?string $category5 = null;

    private ?string $listId = null;

    private ?string $listName = null;

    private ?string $variant = null;

    private ?string $locationId = null;

    private ?float $price = null;

    private int $quantity = 1;

    public static function create(string $id = null, string $name = null): self
    {
        if (null === $id && null === $name) {
            throw new \InvalidArgumentException('Either the id or name must be present');
        }

        $obj = new self();
        $obj->id = $id;
        $obj->name = $name;

        return $obj;
    }

    public function jsonSerialize(): array
    {
        $data = [
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
        ];

        return array_filter($data);
    }

    public function withId(?string $id): self
    {
        return $this->with('id', $id);
    }

    public function withName(?string $name): self
    {
        return $this->with('name', $name);
    }

    public function withAffiliation(?string $affiliation): self
    {
        return $this->with('affiliation', $affiliation);
    }

    public function withCoupon(?string $coupon): self
    {
        return $this->with('coupon', $coupon);
    }

    public function withCurrency(?string $currency): self
    {
        return $this->with('currency', $currency);
    }

    public function withDiscount(?float $discount): self
    {
        return $this->with('discount', $discount);
    }

    public function withIndex(?int $index): self
    {
        return $this->with('index', $index);
    }

    public function withBrand(?string $brand): self
    {
        return $this->with('brand', $brand);
    }

    public function withCategory(?string $category): self
    {
        return $this->with('category', $category);
    }

    public function withCategory2(?string $category2): self
    {
        return $this->with('category2', $category2);
    }

    public function withCategory3(?string $category3): self
    {
        return $this->with('category3', $category3);
    }

    public function withCategory4(?string $category4): self
    {
        return $this->with('category4', $category4);
    }

    public function withCategory5(?string $category5): self
    {
        return $this->with('category5', $category5);
    }

    public function withListId(?string $listId): self
    {
        return $this->with('listId', $listId);
    }

    public function withListName(?string $listName): self
    {
        return $this->with('listName', $listName);
    }

    public function withVariant(?string $variant): self
    {
        return $this->with('variant', $variant);
    }

    public function withLocationId(?string $locationId): self
    {
        return $this->with('locationId', $locationId);
    }

    public function withPrice(?float $price): self
    {
        return $this->with('price', $price);
    }

    public function withQuantity(int $quantity): self
    {
        return $this->with('quantity', $quantity);
    }
}
