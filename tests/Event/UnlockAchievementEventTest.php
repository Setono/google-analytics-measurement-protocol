<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

use PHPUnit\Framework\TestCase;

final class UnlockAchievementEventTest extends TestCase
{
    /**
     * @test
     */
    public function it_returns_array(): void
    {
        $event = new UnlockAchievementEvent();
        $event->parameters->achievementId = 'A_12345';

        self::assertSame(['name' => 'unlock_achievement', 'params' => ['achievement_id' => 'A_12345']], $event->toArray());
    }
}
