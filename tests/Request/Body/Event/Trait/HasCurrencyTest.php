<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait;

use PHPUnit\Framework\TestCase;

final class HasCurrencyTest extends TestCase
{
    /**
     * @test
     */
    public function it_instantiates(): void
    {
        $obj = new ClassUsingHasCurrency();
        self::assertNull($obj->getCurrency());
    }

    /**
     * @test
     */
    public function it_is_mutable(): void
    {
        $obj = new ClassUsingHasCurrency();
        $obj->setCurrency('value');
        self::assertSame('value', $obj->getCurrency());
    }
}

final class ClassUsingHasCurrency
{
    use HasCurrency;
}
