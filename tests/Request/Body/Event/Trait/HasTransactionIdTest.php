<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait;

use PHPUnit\Framework\TestCase;

final class HasTransactionIdTest extends TestCase
{
    /**
     * @test
     */
    public function it_instantiates(): void
    {
        $obj = new ClassUsingHasTransactionId();
        self::assertNull($obj->getTransactionId());
    }

    /**
     * @test
     */
    public function it_is_mutable(): void
    {
        $obj = new ClassUsingHasTransactionId();
        $obj->setTransactionId('value');
        self::assertSame('value', $obj->getTransactionId());
    }
}

final class ClassUsingHasTransactionId
{
    use HasTransactionId;
}
