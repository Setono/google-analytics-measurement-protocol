<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Traits;

trait HasListName
{
    protected ?string $listName = null;

    public function getListName(): ?string
    {
        return $this->listName;
    }

    /**
     * @return static
     */
    public function setListName(?string $listName): self
    {
        $this->listName = $listName;

        return $this;
    }
}
