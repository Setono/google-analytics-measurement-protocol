<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event;

use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Traits\HasSessionId;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Request;

// todo add validate method
abstract class Event
{
    use HasSessionId;

    /**
     * MUST return the event name, e.g. add_to_cart, purchase etc
     * See https://developers.google.com/analytics/devguides/collection/protocol/ga4/reference/events for an event reference
     */
    abstract public function getEventName(): string;

    /**
     * Returns the event parameters
     */
    abstract protected function getParameters(): array;

    /**
     * @param string $trackingContext Indicates whether this event should be treated as a server side or client side event
     */
    public function getPayload(string $trackingContext = Request::TRACKING_CONTEXT_SERVER_SIDE): array
    {
        if (Request::TRACKING_CONTEXT_SERVER_SIDE === $trackingContext) {
            return [
                'name' => $this->getEventName(),
                'params' => array_filter($this->getParameters()),
            ];
        }

        return array_filter($this->getParameters());
    }
}
