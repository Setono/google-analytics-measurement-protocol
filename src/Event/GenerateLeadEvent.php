<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

/**
 * @property GenerateLeadEventParameters $parameters
 */
final class GenerateLeadEvent extends Event
{
    /** Log this event when a lead has been generated to understand the efficacy of your re-engagement campaigns. */
    protected string $name = 'generate_lead';

    public function __construct()
    {
        $this->parameters = new GenerateLeadEventParameters();
    }
}
