<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Traits;

trait HasTransactionId
{
    protected ?string $transactionId = null;

    public function getTransactionId(): ?string
    {
        return $this->transactionId;
    }

    /**
     * @return static
     */
    public function setTransactionId(?string $transactionId): self
    {
        $this->transactionId = $transactionId;

        return $this;
    }
}
