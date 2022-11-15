<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Client;

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Psr\Http\Client\ClientInterface as HttpClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Request;

final class Client implements ClientInterface
{
    private string $host = 'www.google-analytics.com';

    private bool $debug = false;

    private ?HttpClientInterface $httpClient = null;

    private ?RequestFactoryInterface $requestFactory = null;

    private ?StreamFactoryInterface $streamFactory = null;

    private ?ResponseInterface $lastResponse = null;

    public function sendRequest(Request $request): void
    {
        $uri = sprintf(
            'https://%s/%s?measurement_id=%s&api_secret=%s',
            $this->host,
            $this->debug ? 'debug/mp/collect' : 'mp/collect',
            $request->getMeasurementId(),
            $request->getApiSecret(),
        );

        $this->lastResponse = $this->getHttpClient()->sendRequest(
            $this->getRequestFactory()
                ->createRequest('POST', $uri)
                    ->withBody(
                        $this->getStreamFactory()->createStream(json_encode($request->getBody(), \JSON_THROW_ON_ERROR)),
                    ),
        );
    }

    public function getLastResponse(): ?ResponseInterface
    {
        return $this->lastResponse;
    }

    public function setHost(string $host): void
    {
        $this->host = $host;
    }

    public function setDebug(bool $debug = true): void
    {
        $this->debug = $debug;
    }

    public function setHttpClient(?HttpClientInterface $httpClient): void
    {
        $this->httpClient = $httpClient;
    }

    public function setRequestFactory(?RequestFactoryInterface $requestFactory): void
    {
        $this->requestFactory = $requestFactory;
    }

    public function setStreamFactory(?StreamFactoryInterface $streamFactory): void
    {
        $this->streamFactory = $streamFactory;
    }

    private function getHttpClient(): HttpClientInterface
    {
        if (null === $this->httpClient) {
            $this->httpClient = Psr18ClientDiscovery::find();
        }

        return $this->httpClient;
    }

    private function getRequestFactory(): RequestFactoryInterface
    {
        if (null === $this->requestFactory) {
            $this->requestFactory = Psr17FactoryDiscovery::findRequestFactory();
        }

        return $this->requestFactory;
    }

    private function getStreamFactory(): StreamFactoryInterface
    {
        if (null === $this->streamFactory) {
            $this->streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        }

        return $this->streamFactory;
    }
}
