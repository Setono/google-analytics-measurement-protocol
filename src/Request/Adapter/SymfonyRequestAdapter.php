<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Adapter;

use Setono\GoogleAnalyticsMeasurementProtocol\Request\LanguageResolverInterface;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\RequestInterface;
use Symfony\Component\HttpFoundation\Request;
use Webmozart\Assert\Assert;

final class SymfonyRequestAdapter implements RequestInterface
{
    private Request $request;

    private LanguageResolverInterface $languageResolver;

    public function __construct(Request $request, LanguageResolverInterface $languageResolver)
    {
        $this->request = $request;
        $this->languageResolver = $languageResolver;
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
        $val = $this->request->query->get($parameter);
        Assert::nullOrString($val);

        return $val;
    }

    public function getReferrer(): ?string
    {
        return $this->request->headers->get('referer');
    }

    public function getLanguage(): ?string
    {
        $acceptLanguage = $this->request->headers->get('accept-language');

        if (!is_string($acceptLanguage)) {
            return null;
        }

        return $this->languageResolver->resolve($acceptLanguage);
    }
}
