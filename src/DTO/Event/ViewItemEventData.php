<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\DTO\Event;

use Setono\GoogleAnalyticsMeasurementProtocol\DTO\DTOInterface;
use Setono\GoogleAnalyticsMeasurementProtocol\DTO\ProductData;
use Setono\GoogleAnalyticsMeasurementProtocol\Hit\HitBuilderInterface;
use Webmozart\Assert\Assert;

final class ViewItemEventData implements DTOInterface
{
    /** @var array<array-key, ProductData> */
    public array $products = [];

    public function applyTo(HitBuilderInterface $hitBuilder): void
    {
        Assert::same(HitBuilderInterface::HIT_TYPE_EVENT, $hitBuilder->getHitType());

        $hitBuilder
            ->setEventCategory('engagement')
            ->setEventAction('view_item')
            ->setProductAction('detail')
        ;

        foreach ($this->products as $product) {
            $product->applyTo($hitBuilder);
        }
    }
}
