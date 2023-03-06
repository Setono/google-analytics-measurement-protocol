<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event;

use JsonSerializable;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait\HasSessionId;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait\Serializable;

// todo add validate method
abstract class Event implements JsonSerializable
{
    use HasSessionId;
    use Serializable;

    /**
     * MUST return the event name, e.g. add_to_cart, purchase etc
     * See https://developers.google.com/analytics/devguides/collection/protocol/ga4/reference/events for an event reference
     */
    abstract public function getEventName(): string;

    public function jsonSerialize(): array
    {
        return [
            'name' => $this->getEventName(),
            'params' => array_filter($this->serialize()),
        ];
    }
}
