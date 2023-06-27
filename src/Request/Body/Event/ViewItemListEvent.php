<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event;

use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Item\Item;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Traits\CreatesEmpty;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Traits\HasItems;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Traits\HasListId;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Traits\HasListName;

class ViewItemListEvent extends Event
{
    public const NAME = 'view_item_list';

    use CreatesEmpty;

    use HasListId;

    use HasListName;

    use HasItems;

    public function getEventName(): string
    {
        return self::NAME;
    }

    protected function getParameters(): array
    {
        return [
            'item_list_id' => $this->listId,
            'item_list_name' => $this->listName,
            'items' => array_map(static fn (Item $item) => $item->getParameters(), $this->items),
        ];
    }
}
