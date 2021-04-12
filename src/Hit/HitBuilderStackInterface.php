<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Hit;

interface HitBuilderStackInterface
{
    public function push(HitBuilderInterface $hitBuilder): void;

    /**
     * @return array<array-key, HitBuilderInterface>
     */
    public function all(): array;
}
