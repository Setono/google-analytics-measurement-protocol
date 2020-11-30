<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

use PHPUnit\Framework\TestCase;

final class SelectContentEventTest extends TestCase
{
    /**
     * @test
     */
    public function it_returns_array(): void
    {
        $event = new SelectContentEvent();
        $event->parameters->contentType = 'product';
        $event->parameters->itemId = 'I_12345';

        self::assertSame(['name' => 'select_content', 'params' => ['content_type' => 'product', 'item_id' => 'I_12345']], $event->toArray());
    }
}
