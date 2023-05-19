<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Traits;

trait HasCoupon
{
    protected ?string $coupon = null;

    public function getCoupon(): ?string
    {
        return $this->coupon;
    }

    /**
     * @return static
     */
    public function setCoupon(?string $coupon): self
    {
        $this->coupon = $coupon;

        return $this;
    }
}
