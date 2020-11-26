<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

/**
 * @property ViewItemEventParameters $parameters
 */
final class ViewItemEvent extends Event
{
    /** This event signifies that some content was shown to the user. Use this event to discover the most popular items viewed. */
    protected string $name = 'view_item';

    public function __construct()
    {
        $this->parameters = new ViewItemEventParameters();
    }
}
