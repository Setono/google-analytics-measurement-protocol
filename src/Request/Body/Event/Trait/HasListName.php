<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait;

trait HasListName
{
    protected ?string $listName = null;

    public function getListName(): ?string
    {
        return $this->listName;
    }

    public function setListName(?string $listName): static
    {
        $this->listName = $listName;

        return $this;
    }
}
