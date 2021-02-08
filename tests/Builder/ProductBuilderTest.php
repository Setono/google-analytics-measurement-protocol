<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Builder;

/**
 * @covers \Setono\GoogleAnalyticsMeasurementProtocol\Builder\ProductBuilder
 */
final class ProductBuilderTest extends TestCase
{
    /**
     * @test
     */
    public function it_returns_query_with_parameters(): void
    {
        $builder = new ProductBuilder(1);
        $builder->setSku('sku');
        $builder->setName('name');
        $builder->setBrand('brand');
        $builder->setCategory('category');
        $builder->setVariant('variant');
        $builder->setPrice(123.51);
        $builder->setCouponCode('coupon_123');
        $builder->setPosition(10);
        $builder->setCustomDimension(1, 'Member');
        $builder->setCustomDimension(2, 'Paying');
        $builder->setCustomMetric(1, 123);
        $builder->setCustomMetric(2, 788);

        self::assertPayload(<<<QUERY
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
            QUERY, $builder->getPayload());
    }

    /**
     * @test
     */
    public function it_throws_exception_if_the_property_is_not_valid(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The property "nonExistingProperty" does not exist on this payload builder');

        $builder = new ProductBuilder(1);
        $builder->setNonExistingProperty('test');
    }
}
