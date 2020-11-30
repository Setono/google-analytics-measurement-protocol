<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

use PHPUnit\Framework\TestCase;

final class PostScoreEventTest extends TestCase
{
    /**
     * @test
     */
    public function it_returns_array(): void
    {
        $event = new PostScoreEvent();
        $event->parameters->score = 10000;
        $event->parameters->level = 5;
        $event->parameters->character = 'Player 1';

        self::assertSame(['name' => 'post_score', 'params' => ['score' => 10000, 'level' => 5, 'character' => 'Player 1']], $event->toArray());
    }
}
