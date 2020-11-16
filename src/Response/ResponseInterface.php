<?php
declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Response;

interface ResponseInterface
{
    /**
     * Returns the contents in the <title> tag if a <title> tag is present, else it returns null
     */
    public function getTitle(): ?string;
}
