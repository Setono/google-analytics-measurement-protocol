<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Client;

use Setono\GoogleAnalyticsMeasurementProtocol\Request\Request;

interface ClientInterface
{
    public function sendRequest(Request $request): void;
}
