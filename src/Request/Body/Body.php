<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body;

use Setono\GoogleAnalyticsMeasurementProtocol\Attribute\Serialize;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Event;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait\Serializable;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\HasSetters;

final class Body implements \JsonSerializable
{
    use HasSetters;
    use Serializable;

    /**
     * Uniquely identifies a user instance of a web client
     */
    #[Serialize(name: 'client_id')]
    private string $clientId;

    /**
     * Optional. A unique identifier for a user. See https://support.google.com/analytics/answer/9213390 for more information on this identifier
     */
    #[Serialize(name: 'user_id')]
    private ?string $userId = null;

    /**
     * Optional. A Unix timestamp (in microseconds) for the time to associate with the event.
     * This should only be set to record events that happened in the past.
     * This value can be overridden via user_property or event timestamps.
     * Events can be backdated up to 3 calendar days based on the property's timezone.
     */
    #[Serialize(name: 'timestamp_micros')]
    private int $timestamp;

    /**
     * Optional. The user properties for the measurement.
     * See https://developers.google.com/analytics/devguides/collection/protocol/ga4/user-properties for more information.
     *
     * @var array<string, mixed>
     */
    #[Serialize(name: 'user_properties')]
    private array $userProperties = [];

    /**
     * Optional. Set to true to indicate these events should not be used for personalized ads.
     */
    #[Serialize(name: 'non_personalized_ads')]
    private ?bool $nonPersonalizedAds = null;

    /**
     * An array of event items. Up to 25 events can be sent per request.
     * See https://developers.google.com/analytics/devguides/collection/protocol/ga4/reference/events for all valid events.
     *
     * @var list<Event>
     */
    #[Serialize]
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

    /**
     * @param mixed $value
     */
    public function setUserProperty(string $property, $value): self
    {
        $this->userProperties[$property] = $value;

        return $this;
    }

    /**
     * @param array<string, mixed> $userProperties
     */
    public function setUserProperties(array $userProperties): self
    {
        /** @var mixed $value */
        foreach ($userProperties as $userProperty => $value) {
            $this->setUserProperty($userProperty, $value);
        }

        return $this;
    }

    public function getNonPersonalizedAds(): ?bool
    {
        return $this->nonPersonalizedAds;
    }

    public function setNonPersonalizedAds(?bool $nonPersonalizedAds): self
    {
        return $this->set('nonPersonalizedAds', $nonPersonalizedAds);
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
        return array_filter($this->serialize(), static function ($value): bool {
            return $value !== null && [] !== $value;
        });
    }
}
