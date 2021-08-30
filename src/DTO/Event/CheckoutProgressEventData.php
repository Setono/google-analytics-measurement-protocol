<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\DTO\Event;

use Setono\GoogleAnalyticsMeasurementProtocol\DTO\DTOInterface;
use Setono\GoogleAnalyticsMeasurementProtocol\DTO\ProductData;
use Setono\GoogleAnalyticsMeasurementProtocol\Hit\HitBuilderInterface;
use Webmozart\Assert\Assert;

final class CheckoutProgressEventData implements DTOInterface
{
    public ?string $coupon = null;

    public ?string $currency = null;

    public ?string $checkoutOption = null;

    public ?int $checkoutStep = null;

    /** @var array<array-key, ProductData> */
    public array $products = [];

    public function applyTo(HitBuilderInterface $hitBuilder): void
    {
        Assert::same(HitBuilderInterface::HIT_TYPE_EVENT, $hitBuilder->getHitType());

        $hitBuilder
            ->setEventCategory('ecommerce')
            ->setEventAction('checkout_progress')
            ->setProductAction('checkout')
        ;

        if (null !== $this->currency) {
            $hitBuilder->setCurrencyCode($this->currency);
        }

        if (null !== $this->checkoutOption) {
            $hitBuilder->setCheckoutStepOption($this->checkoutOption);
        }

        if (null !== $this->checkoutStep) {
            $hitBuilder->setCheckoutStep($this->checkoutStep);
        }

        foreach ($this->products as $product) {
            if (null === $product->couponCode && null !== $this->coupon) {
                $product->couponCode = $this->coupon;
            }

            $product->applyTo($hitBuilder);
        }
    }
}
