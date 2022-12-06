<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event;

use JsonSerializable;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait\HasSessionId;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait\Serializable;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\HasSetters;

// todo add validate method
abstract class Event implements JsonSerializable
{
    use HasSetters;
    use HasSessionId;
    use Serializable;

    /**
     * MUST return the event name, e.g. add_to_cart, purchase etc
     */
    abstract protected function getEventName(): string;

    public function jsonSerialize(): array
    {
        return [
            'name' => $this->getEventName(),
            'params' => array_filter($this->serialize()),
        ];
    }
}
