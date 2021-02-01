<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Hit;

final class Hit
{
    private string $query;

    private string $clientId;

    public function __construct(string $query, string $clientId)
    {
        $this->query = $query;
        $this->clientId = $clientId;
    }

    public function getQuery(): string
    {
        return $this->query;
    }

    public function getClientId(): string
    {
        return $this->clientId;
    }
}
