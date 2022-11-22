<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait;

use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Event;

/**
 * @mixin Event
 */
trait HasListName
{
    protected ?string $listName = null;

    public function getListName(): ?string
    {
        return $this->listName;
    }

    public function withListName(?string $listName): self
    {
        return $this->with('listName', $listName);
    }
}