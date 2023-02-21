<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Trait;

use PHPUnit\Framework\TestCase;

final class HasCouponTest extends TestCase
{
    /**
     * @test
     */
    public function it_instantiates(): void
    {
        $obj = new ClassUsingHasCoupon();
        self::assertNull($obj->getCoupon());
    }

    /**
     * @test
     */
    public function it_is_mutable(): void
    {
        $obj = new ClassUsingHasCoupon();
        $obj->setCoupon('value');
        self::assertSame('value', $obj->getCoupon());
    }
}

final class ClassUsingHasCoupon
{
    use HasCoupon;
}
