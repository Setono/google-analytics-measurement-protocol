<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Client;

use Setono\GoogleAnalyticsMeasurementProtocol\Request\RequestInterface;

interface ClientInterface
{
    public function sendRequest(RequestInterface $request): void;
}
