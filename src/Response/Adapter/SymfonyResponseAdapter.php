<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Response\Adapter;

use function Safe\preg_match;
use function Safe\preg_replace;
use Setono\GoogleAnalyticsMeasurementProtocol\Response\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;
use Webmozart\Assert\Assert;

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

        $title = $matches[1] ?? '';
        Assert::string($title);

        $title = preg_replace('/[\s]+/', ' ', $title);
        Assert::string($title);

        if ('' === $title) {
            return null;
        }

        return $title;
    }
}
