<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Builder;

final class ProductBuilderTest extends TestCase
{
    /**
     * @test
     */
    public function it_returns_query(): void
    {
        $builder = new ProductBuilder(1);
        self::assertSame('', $builder->getQuery());
    }

    /**
     * @test
     */
    public function it_returns_query_with_parameters(): void
    {
        $builder = new ProductBuilder(1);
        $builder->sku = 'sku';
        $builder->name = 'name';
        $builder->brand = 'brand';
        $builder->category = 'category';
        $builder->variant = 'variant';
        $builder->price = 123.51;
        $builder->couponCode = 'coupon_123';
        $builder->position = 10;
        $builder->setCustomDimension(1, 'Member');
        $builder->setCustomDimension(2, 'Paying');
        $builder->setCustomMetric(1, 123);
        $builder->setCustomMetric(2, 788);

        self::assertBuilder(<<<QUERY
            pr1id=sku
            &pr1nm=name
            &pr1br=brand
            &pr1ca=category
            &pr1va=variant
            &pr1pr=123.51
            &pr1cc=coupon_123
            &pr1ps=10
            &pr1cd1=Member
            &pr1cd2=Paying
            &pr1cm1=123
            &pr1cm2=788
            QUERY, $builder);
    }
}
