<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Builder;

/**
 * @covers \Setono\GoogleAnalyticsMeasurementProtocol\Builder\ProductBuilder
 * @runTestsInSeparateProcesses We need this because the ProductBuilder uses a static variable
 */
final class ProductBuilderTest extends TestCase
{
    /**
     * @test
     * @dataProvider indices
     */
    public function it_returns_query_with_parameters(?int $index): void
    {
        $builder = new ProductBuilder($index);
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

        $query = <<<QUERY
            pr[INDEX]id=sku
            &pr[INDEX]nm=name
            &pr[INDEX]br=brand
            &pr[INDEX]ca=category
            &pr[INDEX]va=variant
            &pr[INDEX]pr=123.51
            &pr[INDEX]cc=coupon_123
            &pr[INDEX]ps=10
            &pr[INDEX]cd1=Member
            &pr[INDEX]cd2=Paying
            &pr[INDEX]cm1=123
            &pr[INDEX]cm2=788
QUERY;
        $query = str_replace('[INDEX]', $index ?? 1, $query);

        self::assertPayload($query, $builder->getPayload());
    }

    public function indices(): array
    {
        return [[null], [1], [200]];
    }

    /**
     * @test
     */
    public function it_throws_exception_if_index_is_too_low(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new ProductBuilder(0);
    }

    /**
     * @test
     */
    public function it_throws_exception_if_index_is_too_high(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new ProductBuilder(201);
    }
}
