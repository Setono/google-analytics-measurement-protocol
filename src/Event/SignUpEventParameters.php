<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

final class SignUpEventParameters extends EventParameters
{
    /**
     * The method used for sign up.
     * Required: No
     * Example: Google
     */
    public string $method;
}
