<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait;

use Setono\GoogleAnalyticsMeasurementProtocol\Attribute\Serialize;

trait HasListId
{
    #[Serialize(name: 'item_list_id')]
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
