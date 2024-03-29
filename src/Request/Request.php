<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request;

use Setono\GoogleAnalyticsEvents\Event\Event;

final class Request implements RequestInterface
{
    /**
     * Measurement ID. The identifier for a Data Stream. Found in the Google Analytics UI under:
     * Admin > Data Streams > choose your stream > Measurement ID
     */
    private string $measurementId;

    /**
     * To create a new secret, navigate in the Google Analytics UI to:
     * Admin > Data Streams > choose your stream > Measurement Protocol > Create
     */
    private string $apiSecret;

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
     *
     * @var array<string, mixed>
     */
    private array $userProperties = [];

    /**
     * Optional. Set to true to indicate these events should not be used for personalized ads.
     */
    private ?bool $nonPersonalizedAds = null;

    /**
     * An array of event items. Up to 25 events can be sent per request.
     * See https://developers.google.com/analytics/devguides/collection/protocol/ga4/reference/events for all valid events.
     *
     * @var list<Event>
     */
    private array $events = [];

    public function __construct(string $measurementId, string $apiSecret, string $clientId)
    {
        $this->measurementId = $measurementId;
        $this->apiSecret = $apiSecret;
        $this->clientId = $clientId;
        $this->timestamp = (int) (microtime(true) * 1_000_000);
    }

    public function getMeasurementId(): string
    {
        return $this->measurementId;
    }

    public function setMeasurementId(string $measurementId): self
    {
        $this->measurementId = $measurementId;

        return $this;
    }

    public function getApiSecret(): string
    {
        return $this->apiSecret;
    }

    public function setApiSecret(string $apiSecret): self
    {
        $this->apiSecret = $apiSecret;

        return $this;
    }

    public function getClientId(): string
    {
        return $this->clientId;
    }

    public function setClientId(string $clientId): self
    {
        $this->clientId = $clientId;

        return $this;
    }

    public function getUserId(): ?string
    {
        return $this->userId;
    }

    public function setUserId(?string $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    public function setTimestamp(int $timestamp): self
    {
        $this->timestamp = $timestamp;

        return $this;
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
        // See https://developers.google.com/analytics/devguides/collection/protocol/ga4/user-properties?client_type=gtag#reserved_names
        if (in_array($property, ['first_open_time', 'first_visit_time', 'last_deep_link_referrer', 'user_id', 'first_open_after_install'], true)) {
            throw new \InvalidArgumentException(sprintf('The user property "%s" is not allowed', $property));
        }

        foreach (['google_', 'ga_', 'firebase_'] as $prefix) {
            if (str_starts_with($property, $prefix)) {
                throw new \InvalidArgumentException(sprintf(
                    'The user property "%s" starts with "%s" and this is not allowed',
                    $property,
                    $prefix,
                ));
            }
        }

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
        $this->nonPersonalizedAds = $nonPersonalizedAds;

        return $this;
    }

    /**
     * @return list<Event>
     */
    public function getEvents(): array
    {
        return $this->events;
    }

    /**
     * @param list<Event> $events
     */
    public function setEvents(array $events): self
    {
        $this->events = [];

        foreach ($events as $event) {
            $this->addEvent($event);
        }

        return $this;
    }

    /**
     * @throws \OutOfBoundsException if you try to add more than 25 events
     */
    public function addEvent(Event $event): self
    {
        if (count($this->events) >= 25) {
            throw new \OutOfBoundsException('The number of events cannot exceed 25');
        }

        $this->events[] = $event;

        return $this;
    }

    public function getPayload(): array
    {
        $events = [];
        foreach ($this->events as $event) {
            $events[] = [
                'name' => $event::getName(),
                'params' => $event->getParameters(),
            ];
        }

        return array_filter([
            'client_id' => $this->clientId,
            'user_id' => $this->userId,
            'timestamp_micros' => $this->timestamp,
            'user_properties' => $this->userProperties,
            'non_personalized_ads' => $this->nonPersonalizedAds,
            'events' => $events,
        ]);
    }
}
