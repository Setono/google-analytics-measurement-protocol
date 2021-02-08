<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Builder;

use PHPUnit\Framework\TestCase as BaseTestCase;
use function Safe\preg_replace;
use Setono\GoogleAnalyticsMeasurementProtocol\Hit\Payload;

abstract class TestCase extends BaseTestCase
{
    public static function assertPayload(string $expectedQuery, Payload $payload): void
    {
        $expectedQuery = trim(preg_replace('/[\s]+/', '', $expectedQuery));

        self::assertSame($expectedQuery, (string) $payload);
    }
}
