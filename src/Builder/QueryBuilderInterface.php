<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Builder;

interface QueryBuilderInterface
{
    /**
     * This method will return the query part of the url to send to Google Analytics.
     *
     * This will be the string you append to the Google Analytics endpoint (i.e. https://www.google-analytics.com/collect)
     */
    public function getQuery(): string;

    public function __toString(): string;
}
