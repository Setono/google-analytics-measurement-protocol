<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

use PHPUnit\Framework\TestCase;

final class SignUpEventTest extends TestCase
{
    /**
     * @test
     */
    public function it_returns_array(): void
    {
        $event = new SignUpEvent();
        $event->parameters->method = 'Google';

        self::assertSame(['name' => 'sign_up', 'params' => ['method' => 'Google']], $event->toArray());
    }
}
