<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event;

use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Item\Item;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait\CreatesEmpty;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait\HasCoupon;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait\HasCurrency;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait\HasItems;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait\HasValue;

class BeginCheckoutEvent extends Event
{
    use CreatesEmpty;
    use HasCurrency;
    use HasValue;
    use HasCoupon;
    use HasItems;

    public function getEventName(): string
    {
        return 'begin_checkout';
    }

    protected function getParameters(): array
    {
        return [
            'currency' => $this->currency,
            'value' => $this->value,
            'coupon' => $this->coupon,
            'items' => array_map(static fn (Item $item) => $item->getParameters(), $this->items),
        ];
    }
}
