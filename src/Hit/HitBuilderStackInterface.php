<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Hit;

interface HitBuilderStackInterface extends \Traversable
{
    public function push(HitBuilderInterface $hitBuilder): void;

    /**
     * If $filter is provided, this filter will be applied before returning the HitBuilders.
     * The callable is given a HitBuilder as the first argument
     *
     * @psalm-param callable(HitBuilderInterface)|null $filter
     *
     * @return array<array-key, HitBuilderInterface>
     */
    public function all(callable $filter = null): array;

    /**
     * Returns hit builders with the type 'pageview'
     *
     * @return array<array-key, HitBuilderInterface>
     */
    public function pageviews(): array;

    /**
     * Returns hit builders with the type 'event'
     *
     * @return array<array-key, HitBuilderInterface>
     */
    public function events(): array;
}
