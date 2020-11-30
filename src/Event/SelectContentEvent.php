<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

/**
 * @property SelectContentEventParameters $parameters
 */
final class SelectContentEvent extends Event
{
    /** This event signifies that a user has selected some content of a certain type. This event can help you identify popular content and categories of content in your app. */
    protected string $name = 'select_content';

    public function __construct()
    {
        $this->parameters = new SelectContentEventParameters();
    }
}
