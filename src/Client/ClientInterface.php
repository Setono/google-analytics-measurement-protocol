<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Client;

use Setono\GoogleAnalyticsMeasurementProtocol\Client\Response\ResponseInterface;

interface ClientInterface
{
    /**
     * @param string $q A payload query string, i.e. v=1&tid=UA-XXXXX-Y&cid=555&t=pageview
     */
    public function sendHit(string $q): ResponseInterface;
}
