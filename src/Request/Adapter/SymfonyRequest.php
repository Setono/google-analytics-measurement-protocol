<?php
declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Adapter;

use Setono\GoogleAnalyticsMeasurementProtocol\Request\RequestInterface;
use Symfony\Component\HttpFoundation\Request;

final class SymfonyRequest implements RequestInterface
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getUrl(): string
    {
        return $this->request->getUri();
    }

    public function getUserAgent(): string
    {
        return (string) $this->request->headers->get('user-agent');
    }

    public function getIp(): string
    {
        return (string) $this->request->getClientIp();
    }

    public function getQueryValue(string $parameter): ?string
    {
        return $this->request->query->get($parameter);
    }

    public function getReferrer(): ?string
    {
        return $this->request->headers->get('referer');
    }
}
