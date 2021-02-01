<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Builder;

interface PersistableQueryBuilderInterface extends QueryBuilderInterface
{
    public function store(): void;

    public function restore(): void;
}
