<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Traits;

use PHPUnit\Framework\TestCase;

final class HasListIdTest extends TestCase
{
    /**
     * @test
     */
    public function it_instantiates(): void
    {
        $obj = new ClassUsingHasListId();
        self::assertNull($obj->getListId());
    }

    /**
     * @test
     */
    public function it_is_mutable(): void
    {
        $obj = new ClassUsingHasListId();
        $obj->setListId('value');
        self::assertSame('value', $obj->getListId());
    }
}

final class ClassUsingHasListId
{
    use HasListId;
}
