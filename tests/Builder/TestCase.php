<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Builder;

use PHPUnit\Framework\TestCase as BaseTestCase;
use function Safe\preg_replace;

abstract class TestCase extends BaseTestCase
{
    public static function assertBuilder(string $expectedQuery, BuilderInterface $builder): void
    {
        $expectedQuery = trim(preg_replace('/[\s]+/', '', $expectedQuery));

        self::assertSame($expectedQuery, $builder->getQuery());
    }
}
