<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Client;

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18Client;
use Psr\Http\Client\ClientInterface as HttpClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\RequestInterface;

final class Client implements ClientInterface, LoggerAwareInterface
{
    private string $host = 'www.google-analytics.com';

    private bool $debug = false;

    private bool $throw = false;

    private ?HttpClientInterface $httpClient = null;

    private ?RequestFactoryInterface $requestFactory = null;

    private ?StreamFactoryInterface $streamFactory = null;

    private LoggerInterface $logger;

    private ?ResponseInterface $lastResponse = null;

    public function __construct()
    {
        $this->logger = new NullLogger();
    }

    public function sendRequest(RequestInterface $request): void
    {
        try {
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
                        $this->getStreamFactory()->createStream(json_encode($request->getPayload(), \JSON_THROW_ON_ERROR)),
                    ),
            );
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());

            if ($this->throw) {
                throw $e;
            }
        }
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

    /**
     * Set to true if you want the client to throw exceptions.
     * If throw is false it will only log errors to the specified logger.
     */
    public function setThrow(bool $throw = true): void
    {
        $this->throw = $throw;
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
            $this->httpClient = new Psr18Client();
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

    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }
}
