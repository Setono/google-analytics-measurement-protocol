<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Hit;

final class HitBuilderStack implements HitBuilderStackInterface, \IteratorAggregate
{
    /** @var array<array-key, HitBuilderInterface> */
    private array $hitBuilders = [];

    public function push(HitBuilderInterface $hitBuilder): void
    {
        $this->hitBuilders[] = $hitBuilder;
    }

    public function all(): array
    {
        return $this->hitBuilders;
    }

    public function pageviews(): array
    {
        return array_filter(
            $this->hitBuilders,
            static fn (HitBuilderInterface $hitBuilder) => $hitBuilder->getHitType() === HitBuilderInterface::HIT_TYPE_PAGEVIEW
        );
    }

    public function events(): array
    {
        return array_filter(
            $this->hitBuilders,
            static fn (HitBuilderInterface $hitBuilder) => $hitBuilder->getHitType() === HitBuilderInterface::HIT_TYPE_EVENT
        );
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->hitBuilders);
    }
}
