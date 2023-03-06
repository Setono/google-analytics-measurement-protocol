<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event;

use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Item\Item;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait\CreatesEmpty;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait\HasCoupon;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait\HasCurrency;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait\HasItems;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait\HasValue;

class AddPaymentInfoEvent extends Event
{
    use CreatesEmpty;
    use HasCurrency;
    use HasValue;
    use HasCoupon;
    use HasItems;

    protected ?string $paymentType = null;

    public function getEventName(): string
    {
        return 'add_payment_info';
    }

    public function getPaymentType(): ?string
    {
        return $this->paymentType;
    }

    public function setPaymentType(?string $paymentType): self
    {
        $this->paymentType = $paymentType;

        return $this;
    }

    protected function getParameters(): array
    {
        return [
            'currency' => $this->currency,
            'value' => $this->value,
            'coupon' => $this->coupon,
            'payment_type' => $this->paymentType,
            'items' => array_map(static fn (Item $item) => $item->getParameters(), $this->items),
        ];
    }
}
