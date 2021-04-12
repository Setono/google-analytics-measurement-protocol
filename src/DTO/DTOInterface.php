<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\DTO;

use Setono\GoogleAnalyticsMeasurementProtocol\Hit\HitBuilderInterface;

interface DTOInterface
{
    /**
     * Applies the DTO details to the given hit builder object
     */
    public function applyTo(HitBuilderInterface $hitBuilder): void;
}
