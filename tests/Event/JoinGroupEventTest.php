<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

use PHPUnit\Framework\TestCase;

final class JoinGroupEventTest extends TestCase
{
    /**
     * @test
     */
    public function it_returns_array(): void
    {
        $event = new JoinGroupEvent();
        $event->parameters->groupId = 'G_12345';

        self::assertSame(['name' => 'join_group', 'params' => ['group_id' => 'G_12345']], $event->toArray());
    }
}
