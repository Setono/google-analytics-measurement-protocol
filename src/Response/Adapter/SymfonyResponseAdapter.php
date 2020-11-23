<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Response\Adapter;

use function Safe\preg_match;
use function Safe\preg_replace;
use Setono\GoogleAnalyticsMeasurementProtocol\Response\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;

final class SymfonyResponseAdapter implements ResponseInterface
{
    private Response $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function getTitle(): ?string
    {
        $content = $this->response->getContent();
        if (false === $content) {
            return null;
        }

        if (preg_match('#<title>(.*?)</title>#is', $content, $matches) === 0) {
            return null;
        }

        if (!isset($matches[1])) {
            return null;
        }

        $title = $matches[1];
        if (!is_string($title)) {
            return null;
        }

        /** @var string $title */
        $title = preg_replace('/[\s]+/', ' ', $title);

        return $title;
    }
}
