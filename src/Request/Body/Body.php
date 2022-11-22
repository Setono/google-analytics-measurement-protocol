<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body;

use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Event;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\HasSetters;

final class Body implements \JsonSerializable
{
    use HasSetters;

    /**
     * Uniquely identifies a user instance of a web client
     */
    private string $clientId;

    /**
     * Optional. A unique identifier for a user. See https://support.google.com/analytics/answer/9213390 for more information on this identifier
     */
    private ?string $userId = null;

    /**
     * Optional. A Unix timestamp (in microseconds) for the time to associate with the event.
     * This should only be set to record events that happened in the past.
     * This value can be overridden via user_property or event timestamps.
     * Events can be backdated up to 3 calendar days based on the property's timezone.
     */
    private int $timestamp;

    /**
     * Optional. The user properties for the measurement.
     * See https://developers.google.com/analytics/devguides/collection/protocol/ga4/user-properties for more information.
     */
    private array $userProperties = [];

    /**
     * Optional. Set to false to indicate these events should not be used for personalized ads.
     */
    private ?bool $personalizedAds = null;

    /**
     * An array of event items. Up to 25 events can be sent per request.
     * See https://developers.google.com/analytics/devguides/collection/protocol/ga4/reference/events for all valid events.
     *
     * @var list<Event>
     */
    private array $events = [];

    private function __construct(string $clientId)
    {
        $this->clientId = $clientId;
        $this->timestamp = (int) (microtime(true) * 1_000_000);
    }

    public static function create(string $clientId): self
    {
        return new self($clientId);
    }

    public function getClientId(): string
    {
        return $this->clientId;
    }

    public function setClientId(string $clientId): self
    {
        return $this->set('clientId', $clientId);
    }

    public function getUserId(): ?string
    {
        return $this->userId;
    }

    public function setUserId(?string $userId): self
    {
        return $this->set('userId', $userId);
    }

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    public function setTimestamp(int $timestamp): self
    {
        return $this->set('timestamp', $timestamp);
    }

    public function getUserProperties(): array
    {
        return $this->userProperties;
    }

    public function setUserProperties(array $userProperties): self
    {
        return $this->set('userProperties', $userProperties);
    }

    public function getPersonalizedAds(): ?bool
    {
        return $this->personalizedAds;
    }

    public function setPersonalizedAds(?bool $personalizedAds): self
    {
        return $this->set('personalizedAds', $personalizedAds);
    }

    /**
     * @return list<Event>
     */
    public function getEvents(): array
    {
        return $this->events;
    }

    public function setEvents(array $events): self
    {
        if (count($events) >= 25) {
            throw new \OutOfBoundsException('The number of events cannot exceed 25'); // todo better exception
        }

        return $this->set('events', $events);
    }

    public function addEvent(Event $event): self
    {
        if (count($this->events) >= 25) {
            throw new \OutOfBoundsException('The number of events cannot exceed 25'); // todo better exception
        }

        $this->events[] = $event;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return array_filter([
            'client_id' => $this->clientId,
            'user_id' => $this->userId,
            'timestamp_micros' => $this->timestamp,
            'user_properties' => $this->userProperties, // todo should be an object according to the spec here: https://developers.google.com/analytics/devguides/collection/protocol/ga4/reference?client_type=gtag
            'non_personalized_ads' => null === $this->personalizedAds ? $this->personalizedAds : !$this->personalizedAds,
            'events' => $this->events,
        ], static function ($value): bool {
            return $value !== null && [] !== $value;
        });
    }
}
