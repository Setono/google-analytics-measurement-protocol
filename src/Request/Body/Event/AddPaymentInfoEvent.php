<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event;

use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait\CreatesEmpty;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait\HasCoupon;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait\HasCurrency;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait\HasItems;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait\HasValue;

class AddPaymentInfoEvent extends Event
{
    use CreatesEmpty;
    use HasCurrency;
    use HasItems;
    use HasValue;
    use HasCoupon;

    protected ?string $paymentType = null;

    protected function getEventName(): string
    {
        return 'add_payment_info';
    }

    protected function getData(): array
    {
        return [
            'currency' => $this->currency,
            'value' => $this->value,
            'coupon' => $this->coupon,
            'payment_type' => $this->paymentType,
            'items' => $this->items,
        ];
    }

    public function getPaymentType(): ?string
    {
        return $this->paymentType;
    }

    public function withPaymentType(?string $paymentType): self
    {
        return $this->with('paymentType', $paymentType);
    }
}
