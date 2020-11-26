<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

final class JoinGroupEventParameters extends EventParameters
{
    /**
     * The ID of the group.
     * Required: No
     * Example: G_12345
     */
    public string $groupId;
}
