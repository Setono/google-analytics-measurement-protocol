<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Hit;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Setono\GoogleAnalyticsMeasurementProtocol\Hit\Hit
 */
class HitTest extends TestCase
{
    /**
     * @test
     */
    public function it_returns_correct_values(): void
    {
        $payload = 'v=1';

        $obj = new Hit('property_id', 'client_id', $payload);
        self::assertSame('property_id', $obj->getPropertyId());
        self::assertSame('client_id', $obj->getClientId());
        self::assertSame($payload, $obj->getPayload());
    }
}
