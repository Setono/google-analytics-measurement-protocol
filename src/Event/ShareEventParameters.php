<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

final class ShareEventParameters extends EventParameters
{
    /**
     * The method in which the content is shared.
     * Required: No
     * Example: Twitter
     */
    public string $method;

    /**
     * The type of shared content.
     * Required: No
     * Example: image
     */
    public string $contentType;

    /**
     * The ID of the shared content.
     * Required: No
     * Example: C_12345
     */
    public string $contentId;
}
