<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\DTO\Event;

use Setono\GoogleAnalyticsMeasurementProtocol\DTO\DTOInterface;
use Setono\GoogleAnalyticsMeasurementProtocol\DTO\ProductData;
use Setono\GoogleAnalyticsMeasurementProtocol\Hit\HitBuilderInterface;
use Webmozart\Assert\Assert;

final class AddToCartEventData implements DTOInterface
{
    public ?string $currency = null;

    /**
     * Notice that these are the products added to the cart, not the items already in the cart
     *
     * @var array<array-key, ProductData>
     */
    public array $products = [];

    public function applyTo(HitBuilderInterface $hitBuilder): void
    {
        Assert::same(HitBuilderInterface::HIT_TYPE_EVENT, $hitBuilder->getHitType());

        $hitBuilder
            ->setProductAction('add')
            ->setEventCategory('ecommerce')
            ->setEventAction('add_to_cart')
        ;

        if (null !== $this->currency) {
            $hitBuilder->setCurrencyCode($this->currency);
        }

        foreach ($this->products as $product) {
            $product->applyTo($hitBuilder);
        }
    }
}
