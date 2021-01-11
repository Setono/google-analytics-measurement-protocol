<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Builder;

interface PersistableBuilderInterface extends BuilderInterface
{
    public function store(): void;

    public function restore(): void;
}
