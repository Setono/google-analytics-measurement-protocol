<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Client\Response;

use function Safe\json_decode;

final class DebugResponse implements ResponseInterface
{
    private ResponseInterface $decorated;

    private array $parsingResult;

    public function __construct(ResponseInterface $response)
    {
        $this->decorated = $response;

        /** @var array<array-key, array> $data */
        $data = json_decode($response->getBody(), true)['hitParsingResult'] ?? [];

        $this->parsingResult = $data;
    }

    public function getStatusCode(): int
    {
        return $this->decorated->getStatusCode();
    }

    public function getBody(): string
    {
        return $this->decorated->getBody();
    }

    public function getParsingResult(): array
    {
        return $this->parsingResult;
    }
}
