<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait;

trait HasListId
{
    protected ?string $listId = null;

    public function getListId(): ?string
    {
        return $this->listId;
    }

    public function setListId(?string $listId): static
    {
        $this->listId = $listId;

        return $this;
    }
}
