<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

use PHPUnit\Framework\TestCase;

final class TutorialBeginEventTest extends TestCase
{
    /**
     * @test
     */
    public function it_returns_array(): void
    {
        $event = new TutorialBeginEvent();
        self::assertSame(['name' => 'tutorial_begin'], $event->toArray());
    }
}
