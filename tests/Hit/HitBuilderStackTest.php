<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Hit;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Setono\GoogleAnalyticsMeasurementProtocol\Hit\HitBuilderStack
 */
final class HitBuilderStackTest extends TestCase
{
    /**
     * @test
     */
    public function it_pushes(): void
    {
        $hitBuilder = new HitBuilder(HitBuilderInterface::HIT_TYPE_PAGEVIEW);

        $stack = new HitBuilderStack();
        $stack->push($hitBuilder);

        $actual = $stack->all();
        self::assertCount(1, $actual);
        self::assertSame($hitBuilder, array_pop($actual));
    }

    /**
     * @test
     */
    public function it_returns_pageviews(): void
    {
        $stack = new HitBuilderStack();
        $stack->push(new HitBuilder(HitBuilderInterface::HIT_TYPE_EVENT));
        $stack->push(new HitBuilder(HitBuilderInterface::HIT_TYPE_PAGEVIEW));
        $stack->push(new HitBuilder(HitBuilderInterface::HIT_TYPE_EXCEPTION));

        $pageviews = $stack->pageviews();
        self::assertCount(1, $pageviews);
        self::assertSame(HitBuilderInterface::HIT_TYPE_PAGEVIEW, current($pageviews)->getHitType());
    }

    /**
     * @test
     */
    public function it_returns_events(): void
    {
        $stack = new HitBuilderStack();
        $stack->push(new HitBuilder(HitBuilderInterface::HIT_TYPE_EVENT));
        $stack->push(new HitBuilder(HitBuilderInterface::HIT_TYPE_PAGEVIEW));
        $stack->push(new HitBuilder(HitBuilderInterface::HIT_TYPE_EXCEPTION));

        $events = $stack->events();
        self::assertCount(1, $events);
        self::assertSame(HitBuilderInterface::HIT_TYPE_EVENT, current($events)->getHitType());
    }

    /**
     * @test
     */
    public function it_is_traversable(): void
    {
        $stack = new HitBuilderStack();
        $stack->push(new HitBuilder(HitBuilderInterface::HIT_TYPE_EVENT));
        $stack->push(new HitBuilder(HitBuilderInterface::HIT_TYPE_PAGEVIEW));
        $stack->push(new HitBuilder(HitBuilderInterface::HIT_TYPE_EXCEPTION));

        self::assertInstanceOf(\Traversable::class, $stack);

        $i = 0;
        foreach ($stack as $item) {
            ++$i;
        }

        self::assertSame(3, $i);
    }
}
