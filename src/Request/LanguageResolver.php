<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request;

final class LanguageResolver implements LanguageResolverInterface
{
    public function resolve(string $acceptLanguageHeader): ?string
    {
        $preferredLanguages = array_reduce(
            explode(',', $acceptLanguageHeader),
            static function (array $result, string $el): array {
                [$language, $quality] = array_merge(explode(';q=', $el), [1]);
                $result[$language] = (float) $quality;

                return $result;
            },
            []
        );

        arsort($preferredLanguages);
        if (count($preferredLanguages) > 0) {
            $preferredLanguage = array_key_first($preferredLanguages);
            if (is_string($preferredLanguage)) {
                return $preferredLanguage;
            }
        }

        return null;
    }
}
