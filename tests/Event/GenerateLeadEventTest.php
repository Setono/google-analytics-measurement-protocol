<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

use PHPUnit\Framework\TestCase;

final class GenerateLeadEventTest extends TestCase
{
    /**
     * @test
     */
    public function it_returns_array(): void
    {
        $event = new GenerateLeadEvent();
        $event->parameters->currency = 'USD';
        $event->parameters->value = 99.99;

        self::assertSame(['name' => 'generate_lead', 'params' => ['currency' => 'USD', 'value' => 99.99]], $event->toArray());
    }
}
