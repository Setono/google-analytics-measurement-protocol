<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Traits;

trait HasListId
{
    protected ?string $listId = null;

    public function getListId(): ?string
    {
        return $this->listId;
    }

    /**
     * @return static
     */
    public function setListId(?string $listId): self
    {
        $this->listId = $listId;

        return $this;
    }
}
