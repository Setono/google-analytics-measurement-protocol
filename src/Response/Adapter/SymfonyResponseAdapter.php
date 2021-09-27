<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Response\Adapter;

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

        if (preg_match('#<title>(.*?)</title>#is', $content, $matches) !== 1) {
            return null;
        }

        $title = trim(html_entity_decode(preg_replace('/[\s]+/', ' ', $matches[1])));

        if ('' === $title) {
            return null;
        }

        return $title;
    }
}
