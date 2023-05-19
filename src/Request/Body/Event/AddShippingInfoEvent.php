<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event;

use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Item\Item;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Traits\CreatesEmpty;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Traits\HasCoupon;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Traits\HasCurrency;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Traits\HasItems;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Traits\HasValue;

class AddShippingInfoEvent extends Event
{
    use CreatesEmpty;
    use HasCurrency;
    use HasValue;
    use HasCoupon;
    use HasItems;

    protected ?string $shippingTier = null;

    public function getEventName(): string
    {
        return 'add_shipping_info';
    }

    public function getShippingTier(): ?string
    {
        return $this->shippingTier;
    }

    public function setShippingTier(?string $shippingTier): self
    {
        $this->shippingTier = $shippingTier;

        return $this;
    }

    protected function getParameters(): array
    {
        return [
            'currency' => $this->currency,
            'value' => $this->value,
            'coupon' => $this->coupon,
            'shipping_tier' => $this->shippingTier,
            'items' => array_map(static fn (Item $item) => $item->getParameters(), $this->items),
        ];
    }
}
