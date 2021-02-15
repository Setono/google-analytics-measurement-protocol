<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Storage\Adapter;

use Setono\GoogleAnalyticsMeasurementProtocol\Storage\StorageInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Webmozart\Assert\Assert;

final class SymfonySessionStorageAdapter implements StorageInterface
{
    private SessionInterface $session;

    private string $keyPrefix;

    public function __construct(SessionInterface $session, string $keyPrefix = 'sgamp_')
    {
        $this->session = $session;
        $this->keyPrefix = $keyPrefix;
    }

    public function store(string $key, string $data): void
    {
        $this->session->set($this->resolveKey($key), $data);
    }

    public function restore(string $key): ?string
    {
        $data = $this->session->get($this->resolveKey($key));
        Assert::nullOrString($data);

        return $data;
    }

    private function resolveKey(string $key): string
    {
        return $this->keyPrefix . $key;
    }
}
