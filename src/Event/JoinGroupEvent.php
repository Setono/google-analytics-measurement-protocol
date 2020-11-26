<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

/**
 * @property JoinGroupEventParameters $parameters
 */
final class JoinGroupEvent extends Event
{
    /** Log this event when a user joins a group such as a guild, team, or family. Use this event to analyze how popular certain groups or social features are. */
    protected string $name = 'join_group';

    public function __construct()
    {
        $this->parameters = new JoinGroupEventParameters();
    }
}
