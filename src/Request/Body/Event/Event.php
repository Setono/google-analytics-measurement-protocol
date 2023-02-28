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

    private bool $serverSide = true;

    private ?string $clientId = null;

    /**
     * MUST return the event name, e.g. add_to_cart, purchase etc
     */
    abstract public function getEventName(): string;

    /**
     * Returns true if the event should be sent server or false if it should be rendered client side
     */
    public function isServerSide(): bool
    {
        return $this->serverSide;
    }

    public function setServerSide(bool $serverSide): self
    {
        $this->serverSide = $serverSide;

        return $this;
    }

    public function getClientId(): ?string
    {
        return $this->clientId;
    }

    public function setClientId(?string $clientId): self
    {
        $this->clientId = $clientId;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'name' => $this->getEventName(),
            'params' => array_filter($this->serialize()),
        ];
    }
}
