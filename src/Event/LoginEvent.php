<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

/**
 * @property LoginEventParameters $parameters
 */
final class LoginEvent extends Event
{
    /** Send this event to signify that a user has logged in. */
    protected string $name = 'login';

    public function __construct()
    {
        $this->parameters = new LoginEventParameters();
    }
}
