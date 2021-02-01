<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Client\Response;

use Psr\Http\Message\ResponseInterface as PsrResponseInterface;

final class Response implements ResponseInterface
{
    private int $statusCode;

    private string $body;

    public function __construct(int $statusCode, string $body)
    {
        $this->statusCode = $statusCode;
        $this->body = $body;
    }

    public static function fromPsrResponse(PsrResponseInterface $response): self
    {
        return new self($response->getStatusCode(), (string) $response->getBody());
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getBody(): string
    {
        return $this->body;
    }
}
