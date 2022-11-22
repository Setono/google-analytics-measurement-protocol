<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request;

use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Body;

final class Request
{
    use HasSetters;

    /**
     * To create a new secret, navigate in the Google Analytics UI to:
     * Admin > Data Streams > choose your stream > Measurement Protocol > Create
     */
    private string $apiSecret;

    /**
     * Measurement ID. The identifier for a Data Stream. Found in the Google Analytics UI under:
     * Admin > Data Streams > choose your stream > Measurement ID
     */
    private string $measurementId;

    private Body $body;

    public function __construct(string $apiSecret, string $measurementId, Body $body)
    {
        $this->apiSecret = $apiSecret;
        $this->measurementId = $measurementId;
        $this->body = $body;
    }

    public function getApiSecret(): string
    {
        return $this->apiSecret;
    }

    public function setApiSecret(string $apiSecret): self
    {
        return $this->set('apiSecret', $apiSecret);
    }

    public function getMeasurementId(): string
    {
        return $this->measurementId;
    }

    public function setMeasurementId(string $measurementId): self
    {
        return $this->set('measurementId', $measurementId);
    }

    public function getBody(): Body
    {
        return $this->body;
    }

    public function setBody(Body $body): self
    {
        return $this->set('body', $body);
    }
}
