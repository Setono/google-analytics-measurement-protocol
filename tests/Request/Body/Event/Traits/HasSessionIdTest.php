<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Traits;

use PHPUnit\Framework\TestCase;

final class HasSessionIdTest extends TestCase
{
    /**
     * @test
     */
    public function it_instantiates(): void
    {
        $obj = new ClassUsingHasSessionId();
        self::assertNull($obj->getSessionId());
    }

    /**
     * @test
     */
    public function it_is_mutable(): void
    {
        $obj = new ClassUsingHasSessionId();
        $obj->setSessionId('value');
        self::assertSame('value', $obj->getSessionId());
    }
}

final class ClassUsingHasSessionId
{
    use HasSessionId;
}
