<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

use PHPUnit\Framework\TestCase;

final class ShareEventTest extends TestCase
{
    /**
     * @test
     */
    public function it_returns_array(): void
    {
        $event = new ShareEvent();
        $event->parameters->method = 'Twitter';
        $event->parameters->contentType = 'image';
        $event->parameters->contentId = 'C_12345';

        self::assertSame([
            'name' => 'share',
            'params' => ['method' => 'Twitter', 'content_type' => 'image', 'content_id' => 'C_12345'],
        ], $event->toArray());
    }
}
