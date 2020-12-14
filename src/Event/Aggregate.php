<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

class Aggregate
{
    public string $clientId;

    /** @var array&EventInterface[] */
    public array $events;

    public function __construct(string $clientId, EventInterface ...$events)
    {
        $this->clientId = $clientId;
        $this->events = $events;
    }

    public function getClientId(): string
    {
        return $this->clientId;
    }

    public function getEvents(): array
    {
        return $this->events;
    }

    public function addEvent(EventInterface $event): void
    {
        $this->events[] = $event;
    }

    public function toArray(): array
    {
        $events = array_map(static function (EventInterface $event) {
            return $event->toArray();
        }, $this->events);

        return [
            'client_id' => $this->clientId,
            'events' => $events,
        ];
    }
}
