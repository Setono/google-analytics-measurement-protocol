<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request;

interface RequestInterface
{
    /**
     * Returns the full URL of the request, i.e. https://example.com/path/query1=value1
     */
    public function getUrl(): string;

    public function getUserAgent(): string;

    public function getIp(): string;

    /**
     * Returns null if the parameter does not exist
     */
    public function getQueryValue(string $parameter): ?string;

    /**
     * Returns null if no referrer information is present
     */
    public function getReferrer(): ?string;
}
