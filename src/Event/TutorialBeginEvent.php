<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

final class TutorialBeginEvent extends Event
{
    /** This event signifies the start of the on-boarding process. Use this in a funnel with tutorial_complete to understand how many users complete the tutorial. */
    protected string $name = 'tutorial_begin';
}
