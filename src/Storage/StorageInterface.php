<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Storage;

interface StorageInterface
{
    public function store(string $key, string $data): void;

    public function restore(string $key): ?string;
}
