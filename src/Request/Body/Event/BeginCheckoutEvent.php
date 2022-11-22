<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event;

class BeginCheckoutEvent extends Event
{
    use CreatesEmpty;
    use HasCurrency;
    use HasValue;
    use HasCoupon;
    use HasItems;

    protected function getName(): string
    {
        return 'begin_checkout';
    }

    protected function getData(): array
    {
        return [
            'currency' => $this->currency,
            'value' => $this->value,
            'coupon' => $this->coupon,
            'items' => $this->items,
        ];
    }
}
