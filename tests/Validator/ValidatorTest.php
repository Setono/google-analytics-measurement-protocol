<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Validator;

use PHPUnit\Framework\TestCase;
use Setono\GoogleAnalyticsMeasurementProtocol\Builder\HitBuilder;
use Setono\GoogleAnalyticsMeasurementProtocol\Storage\InMemoryStorage;

class ValidatorTest extends TestCase
{
    /**
     * @test
     */
    public function it_does_not_validates(): void
    {
        $validator = new Validator();
        $hitBuilder = new HitBuilder(new InMemoryStorage(), 'test');

        $violations = $validator->validate($hitBuilder);

        self::assertCount(2, $violations);
    }
}
