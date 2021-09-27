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
        $data = ['v' => '1'];

        $obj = new Hit('property_id', 'client_id', $data);
        self::assertSame('property_id', $obj->getPropertyId());
        self::assertSame('client_id', $obj->getClientId());
        self::assertSame($data, $obj->getData());
        self::assertSame('v=1', (string) $obj);
    }
}
