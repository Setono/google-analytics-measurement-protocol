<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Hit;

interface HitBuilderStackInterface extends \Traversable
{
    public function push(HitBuilderInterface $hitBuilder): void;

    /**
     * @return array<array-key, HitBuilderInterface>
     */
    public function all(): array;

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
