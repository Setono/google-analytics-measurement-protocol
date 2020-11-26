<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

final class PostScoreEventParameters extends EventParameters
{
    /**
     * The score to post.
     * Required: Yes
     * Example: 10000
     */
    public int $score;

    /**
     * The level for the score.
     * Required: No
     * Example: 5
     */
    public int $level;

    /**
     * The character that achieved the score.
     * Required: No
     * Example: Player 1
     */
    public string $character;
}
