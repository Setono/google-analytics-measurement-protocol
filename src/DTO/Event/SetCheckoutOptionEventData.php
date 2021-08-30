<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\DTO\Event;

use Setono\GoogleAnalyticsMeasurementProtocol\DTO\DTOInterface;
use Setono\GoogleAnalyticsMeasurementProtocol\Hit\HitBuilderInterface;
use Webmozart\Assert\Assert;

final class SetCheckoutOptionEventData implements DTOInterface
{
    public ?string $checkoutOption = null;

    public ?int $checkoutStep = null;

    public ?int $value = null;

    public function applyTo(HitBuilderInterface $hitBuilder): void
    {
        Assert::same(HitBuilderInterface::HIT_TYPE_EVENT, $hitBuilder->getHitType());

        $hitBuilder
            ->setEventCategory('ecommerce')
            ->setEventAction('set_checkout_option')
            ->setProductAction('checkout_option')
        ;

        if (null !== $this->checkoutOption) {
            $hitBuilder->setCheckoutStepOption($this->checkoutOption);
        }

        if (null !== $this->checkoutStep) {
            $hitBuilder->setCheckoutStep($this->checkoutStep);
        }

        if (null !== $this->value) {
            $hitBuilder->setEventValue($this->value);
        }
    }
}
