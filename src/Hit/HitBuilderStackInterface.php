<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Hit;

interface HitBuilderStackInterface
{
    public function push(HitBuilder $hitBuilder): void;

    /**
     * @return array<array-key, HitBuilder>
     */
    public function all(): array;
}
