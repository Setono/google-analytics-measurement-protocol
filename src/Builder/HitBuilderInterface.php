<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Builder;

use Setono\GoogleAnalyticsMeasurementProtocol\Hit\Hit;

interface HitBuilderInterface extends QueryBuilderInterface
{
    public function getHit(): Hit;
}
