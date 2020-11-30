<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

final class LevelUpEventParameters extends EventParameters
{
    /**
     * The level of the character.
     * Required: No
     * Example: 5
     */
    public int $level;

    /**
     * The character that leveled up.
     * Required: No
     * Example: Player 1
     */
    public string $character;
}
