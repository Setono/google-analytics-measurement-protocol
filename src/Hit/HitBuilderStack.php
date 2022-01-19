<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Hit;

final class HitBuilderStack implements HitBuilderStackInterface, \IteratorAggregate
{
    /** @var array<string, HitBuilderInterface> */
    private array $hitBuilders = [];

    public function push(HitBuilderInterface $hitBuilder): void
    {
        $hash = spl_object_hash($hitBuilder);
        if (isset($this->hitBuilders[$hash])) {
            return;
        }

        $this->hitBuilders[$hash] = $hitBuilder;
    }

    public function all(callable $filter = null): array
    {
        if (null === $filter) {
            return $this->hitBuilders;
        }

        return array_filter($this->hitBuilders, $filter);
    }

    public function pageviews(): array
    {
        return $this->all(
            static fn (HitBuilderInterface $hitBuilder) => $hitBuilder->getHitType() === HitBuilderInterface::HIT_TYPE_PAGEVIEW
        );
    }

    public function events(): array
    {
        return $this->all(
            static fn (HitBuilderInterface $hitBuilder) => $hitBuilder->getHitType() === HitBuilderInterface::HIT_TYPE_EVENT
        );
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->hitBuilders);
    }
}
