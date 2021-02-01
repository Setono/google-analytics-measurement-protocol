<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Client\Response;

interface ResponseInterface
{
    public function getStatusCode(): int;

    public function getBody(): string;
}
