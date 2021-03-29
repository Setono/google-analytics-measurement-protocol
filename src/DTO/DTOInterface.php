<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\DTO;

use Setono\GoogleAnalyticsMeasurementProtocol\Hit\HitBuilder;

interface DTOInterface
{
    /**
     * Applies the DTO details to the given hit builder object
     */
    public function applyTo(HitBuilder $hitBuilder): void;
}
