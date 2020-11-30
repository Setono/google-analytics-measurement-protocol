<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

use PHPUnit\Framework\TestCase;

final class LoginEventTest extends TestCase
{
    /**
     * @test
     */
    public function it_returns_array(): void
    {
        $event = new LoginEvent();
        $event->parameters->method = 'Google';

        self::assertSame(['name' => 'login', 'params' => ['method' => 'Google']], $event->toArray());
    }
}
