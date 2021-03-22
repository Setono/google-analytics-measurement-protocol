<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Hit;

use PHPUnit\Framework\TestCase as BaseTestCase;
use function Safe\preg_replace;

abstract class TestCase extends BaseTestCase
{
    public static function assertHit(string $expectedQuery, Hit $hit): void
    {
        $expectedQuery = trim(preg_replace('/[\t\n]+/', '', $expectedQuery));

        self::assertSame($expectedQuery, $hit->getPayload());
    }
}
