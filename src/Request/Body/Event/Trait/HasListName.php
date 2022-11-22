<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait;

use Setono\GoogleAnalyticsMeasurementProtocol\Attribute\Serialize;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Event;

/**
 * @mixin Event
 */
trait HasListName
{
    #[Serialize(name: 'item_list_name')]
    protected ?string $listName = null;

    public function getListName(): ?string
    {
        return $this->listName;
    }

    public function setListName(?string $listName): static
    {
        return $this->set('listName', $listName);
    }
}
