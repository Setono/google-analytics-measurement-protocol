<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

/**
 * @property ViewItemListEventParameters $parameters
 */
final class ViewItemListEvent extends Event
{
    /** Log this event when the user has been presented with a list of items of a certain category. */
    protected string $name = 'view_item_list';

    public function __construct()
    {
        $this->parameters = new ViewItemListEventParameters();
    }
}
