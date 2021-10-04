<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request;

interface LanguageResolverInterface
{
    /**
     * See
     * - https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Accept-Language and
     * - https://developer.mozilla.org/en-US/docs/Glossary/quality_values
     *
     * Returns null if the given string is not parseable. Returns the language with the highest
     * quality because Analytics does not accept multiple values
     *
     * @param string $acceptLanguageHeader A string of the form: da,en-US;q=0.9,en;q=0.8,nb;q=0.7,ru;q=0.6,de;q=0.5
     */
    public function resolve(string $acceptLanguageHeader): ?string;
}
