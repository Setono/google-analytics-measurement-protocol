<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Hit;

final class Hit
{
    private string $propertyId;

    private string $clientId;

    private string $payload;

    public function __construct(string $propertyId, string $clientId, string $payload)
    {
        $this->propertyId = $propertyId;
        $this->clientId = $clientId;
        $this->payload = $payload;
    }

    public function getPropertyId(): string
    {
        return $this->propertyId;
    }

    public function getClientId(): string
    {
        return $this->clientId;
    }

    public function getPayload(): string
    {
        return $this->payload;
    }

    public function __toString(): string
    {
        return $this->getPayload();
    }
}
