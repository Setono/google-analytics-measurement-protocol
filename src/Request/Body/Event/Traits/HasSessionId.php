<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Traits;

trait HasSessionId
{
    protected ?string $sessionId = null;

    public function getSessionId(): ?string
    {
        return $this->sessionId;
    }

    /**
     * @return static
     */
    public function setSessionId(?string $sessionId): self
    {
        $this->sessionId = $sessionId;

        return $this;
    }
}
