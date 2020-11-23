<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Builder;

use Setono\GoogleAnalyticsMeasurementProtocol\Response\ResponseInterface;

interface ResponseAwareBuilderInterface extends BuilderInterface
{
    /**
     * Will use the response data to populate the builder
     */
    public function populateFromResponse(ResponseInterface $response): void;
}
