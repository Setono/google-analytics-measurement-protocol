<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event;

/**
 * @mixin Event
 */
trait HasCoupon
{
    protected ?string $coupon = null;

    public function withCoupon(?string $coupon): self
    {
        return $this->with('coupon', $coupon);
    }
}
