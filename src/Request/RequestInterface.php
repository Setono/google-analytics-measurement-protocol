<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request;

interface RequestInterface
{
    public function getMeasurementId(): string;

    public function getApiSecret(): string;

    public function getPayload(): array;
}
