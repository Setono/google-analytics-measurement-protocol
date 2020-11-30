<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

use PHPUnit\Framework\TestCase;

final class LevelUpEventTest extends TestCase
{
    /**
     * @test
     */
    public function it_returns_array(): void
    {
        $event = new LevelUpEvent();
        $event->parameters->level = 5;
        $event->parameters->character = 'Player 1';

        self::assertSame(['name' => 'level_up', 'params' => ['level' => 5, 'character' => 'Player 1']], $event->toArray());
    }
}
