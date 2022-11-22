<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait;

use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Event;

/**
 * @mixin Event
 */
trait HasListId
{
    protected ?string $listId = null;

    public function getListId(): ?string
    {
        return $this->listId;
    }

    public function withListId(?string $listId): self
    {
        return $this->with('listId', $listId);
    }
}
