<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

final class SelectItemEventParameters extends EventParameters implements ItemsAwareEventParametersInterface
{
    use ItemsAwareEventParametersTrait;

    /**
     * The name of the list in which the item was presented to the user.
     * Required: No
     * Example: Related products
     */
    public string $itemListName;

    /**
     * The ID of the list in which the item was presented to the user.
     * Required: No
     * Example: related_products
     */
    public string $itemListId;
}
