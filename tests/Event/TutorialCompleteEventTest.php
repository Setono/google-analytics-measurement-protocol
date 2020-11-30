<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

use PHPUnit\Framework\TestCase;

final class TutorialCompleteEventTest extends TestCase
{
    /**
     * @test
     */
    public function it_returns_array(): void
    {
        $event = new TutorialCompleteEvent();
        self::assertSame(['name' => 'tutorial_complete'], $event->toArray());
    }
}
