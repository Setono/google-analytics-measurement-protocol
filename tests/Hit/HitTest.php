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
        $data = ['v' => '1', 'cid' => 'client_id', 'tid' => 'property_id'];

        $obj = new Hit($data);
        self::assertSame('property_id', $obj->getPropertyId());
        self::assertSame('client_id', $obj->getClientId());
        self::assertSame($data, $obj->getData());
    }

    /**
     * @test
     */
    public function it_calculates_queue_time(): void
    {
        $data = ['v' => '1', 'cid' => 'client_id', 'tid' => 'property_id'];

        $then = \DateTimeImmutable::createFromFormat('Y-m-d H:i:s.u', '2021-09-25 12:03:40.123456');
        $now = \DateTimeImmutable::createFromFormat('Y-m-d H:i:s.u', '2021-09-27 14:05:41.456789');
        $qt = 180_121_334; // calculated manually from the two timestamps above

        $obj = new Hit($data, $then);
        self::assertSame('v=1&cid=client_id&tid=property_id&qt=' . $qt, $obj->getPayload($now));
    }
}
