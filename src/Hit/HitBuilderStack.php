<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Hit;

final class HitBuilderStack implements HitBuilderStackInterface
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
}
