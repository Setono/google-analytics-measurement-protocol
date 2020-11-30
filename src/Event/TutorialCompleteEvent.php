<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

final class TutorialCompleteEvent extends Event
{
    /** This event signifies the user's completion of your on-boarding process. Use this in a funnel with tutorial_begin to understand how many users complete the tutorial. */
    protected string $name = 'tutorial_complete';
}
