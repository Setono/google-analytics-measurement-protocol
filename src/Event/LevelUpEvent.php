<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

/**
 * @property LevelUpEventParameters $parameters
 */
final class LevelUpEvent extends Event
{
    /** This event signifies that a player has leveled up. Use it to gauge the level distribution of your userbase and identify levels that are difficult to complete. */
    protected string $name = 'level_up';

    public function __construct()
    {
        $this->parameters = new LevelUpEventParameters();
    }
}
