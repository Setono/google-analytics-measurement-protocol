<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event;

use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Item\Item;

final class AddToCartEvent extends Event
{
    use HasCurrency;
    use HasItems;
    use HasValue;

    /**
     * @param list<Item> $items
     */
    public static function create(string $currency, float $value, array $items = []): self
    {
        $obj = new self();
        $obj->currency = $currency;
        $obj->value = $value;
        $obj->items = $items;

        return $obj;
    }

    protected function getName(): string
    {
        return 'add_to_cart';
    }

    protected function getData(): array
    {
        return [
            'currency' => $this->currency,
            'value' => $this->value,
            'items' => $this->items,
        ];
    }
}
