<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

final class SelectContentEventParameters extends EventParameters
{
    /**
     * The type of selected content.
     * Required: No
     * Example: product
     */
    public string $contentType;

    /**
     * An identifier for the item that was selected.
     * Required: No
     * Example: I_12345
     */
    public string $itemId;
}
