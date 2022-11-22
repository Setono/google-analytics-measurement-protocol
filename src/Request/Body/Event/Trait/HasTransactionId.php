<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait;

use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Event;

/**
 * @mixin Event
 */
trait HasTransactionId
{
    protected string $transactionId;

    public function getTransactionId(): string
    {
        return $this->transactionId;
    }

    public function withTransactionId(string $transactionId): self
    {
        return $this->with('transactionId', $transactionId);
    }
}
