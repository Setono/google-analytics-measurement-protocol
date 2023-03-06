<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait;

trait HasCoupon
{
    protected ?string $coupon = null;

    public function getCoupon(): ?string
    {
        return $this->coupon;
    }

    public function setCoupon(?string $coupon): static
    {
        $this->coupon = $coupon;

        return $this;
    }
}
