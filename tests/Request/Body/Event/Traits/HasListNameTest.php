<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Traits;

use PHPUnit\Framework\TestCase;

final class HasListNameTest extends TestCase
{
    /**
     * @test
     */
    public function it_instantiates(): void
    {
        $obj = new ClassUsingHasListName();
        self::assertNull($obj->getListName());
    }

    /**
     * @test
     */
    public function it_is_mutable(): void
    {
        $obj = new ClassUsingHasListName();
        $obj->setListName('value');
        self::assertSame('value', $obj->getListName());
    }
}

final class ClassUsingHasListName
{
    use HasListName;
}
