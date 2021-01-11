<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Storage;

final class InMemoryStorage implements StorageInterface
{
    /** @var array<string, string> */
    private $data = [];

    public function store(string $key, string $data): void
    {
        $this->data[$key] = $data;
    }

    public function restore(string $key): ?string
    {
        return $this->data[$key] ?? null;
    }
}
