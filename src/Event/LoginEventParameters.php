<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

final class LoginEventParameters extends EventParameters
{
    /**
     * The method used to login.
     * Required: No
     * Example: Google
     */
    public string $method;
}
