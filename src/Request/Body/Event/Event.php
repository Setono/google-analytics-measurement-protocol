<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event;

use JsonSerializable;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\HasWithers;

// todo add validate method
abstract class Event implements JsonSerializable
{
    use HasWithers;

    /**
     * MUST return the event name, e.g. add_to_cart, purchase etc
     */
    abstract protected function getEventName(): string;

    /**
     * MUST return the data ready for serialization
     *
     * @return array<string, mixed>
     */
    abstract protected function getData(): array;

    public function jsonSerialize(): array
    {
        return [
            'name' => $this->getEventName(),
            'params' => array_filter($this->getData()),
        ];
    }
}
