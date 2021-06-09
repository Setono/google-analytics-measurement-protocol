<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Client;

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Psr\Http\Client\ClientInterface as HttpClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Setono\GoogleAnalyticsMeasurementProtocol\Client\Response\DebugResponse;
use Setono\GoogleAnalyticsMeasurementProtocol\Client\Response\Response;
use Setono\GoogleAnalyticsMeasurementProtocol\Client\Response\ResponseInterface;

final class Client implements ClientInterface
{
    private bool $debug = false;

    private HttpClientInterface $httpClient;

    private RequestFactoryInterface $requestFactory;

    private StreamFactoryInterface $streamFactory;

    private string $host;

    public function __construct(
        HttpClientInterface $httpClient = null,
        RequestFactoryInterface $requestFactory = null,
        StreamFactoryInterface $streamFactory = null,
        string $host = 'www.google-analytics.com'
    ) {
        $this->httpClient = $httpClient ?? Psr18ClientDiscovery::find();
        $this->requestFactory = $requestFactory ?? Psr17FactoryDiscovery::findRequestFactory();
        $this->streamFactory = $streamFactory ?? Psr17FactoryDiscovery::findStreamFactory();
        $this->host = $host;
    }

    public function sendHit(string $q): ResponseInterface
    {
        $uri = sprintf('https://%s/%s', $this->host, $this->debug ? 'debug/collect' : 'collect');

        $request = $this->requestFactory->createRequest('POST', $uri);
        $request = $request->withBody($this->streamFactory->createStream($q));

        $response = Response::fromPsrResponse($this->httpClient->sendRequest($request));

        return $this->debug ? new DebugResponse($response) : $response;
    }

    public function setDebug(bool $debug): void
    {
        $this->debug = $debug;
    }
}
