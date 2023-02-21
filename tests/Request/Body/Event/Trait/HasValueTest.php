<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait;

use PHPUnit\Framework\TestCase;

final class HasValueTest extends TestCase
{
    /**
     * @test
     */
    public function it_instantiates(): void
    {
        $obj = new ClassUsingHasValue();
        self::assertNull($obj->getValue());
    }

    /**
     * @test
     */
    public function it_is_mutable(): void
    {
        $obj = new ClassUsingHasValue();
        $obj->setValue(123.45);
        self::assertSame(123.45, $obj->getValue());
    }
}

final class ClassUsingHasValue
{
    use HasValue;
}
