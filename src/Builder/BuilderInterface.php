<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Builder;

interface BuilderInterface
{
    /**
     * This method will return the query part of the url to send to Google Analytics.
     *
     * This will be the string you append to the Google Analytics endpoint (i.e. https://www.google-analytics.com/collect)
     */
    public function getQuery(): string;

    /**
     * This method allows you to create a builder from a query string, i.e. 'v=1&tid=UA-1234-5&aip=0&ds=dataSource&cid=clientId'
     */
    public static function createFromString(string $q): self;

    public function __toString(): string;
}
