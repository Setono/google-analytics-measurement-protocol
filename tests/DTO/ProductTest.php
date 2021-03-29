<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\DTO;

use Setono\GoogleAnalyticsMeasurementProtocol\Hit\HitBuilder;
use Setono\GoogleAnalyticsMeasurementProtocol\TestCase;

/**
 * @covers \Setono\GoogleAnalyticsMeasurementProtocol\DTO\Product
 * @covers \Setono\GoogleAnalyticsMeasurementProtocol\Hit\HitBuilder
 */
class ProductTest extends TestCase
{
    /**
     * @test
     */
    public function it_sets_id_and_name(): void
    {
        $product = Product::createAsProductType('product_id_123', 'Product 123');

        self::assertSame('product_id_123', $product->id);
        self::assertSame('Product 123', $product->name);
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function it_applies_product_properties(): void
    {
        $product = Product::createAsProductType('product_id_123', 'Product 123');
        $product->brand = 'Cool brand';
        $product->variant = 'Black';
        $product->position = 12;
        $product->price = 213.12;
        $product->category = 'Jeans';
        $product->quantity = 2;
        $product->couponCode = '10% off';

        $product->setCustomDimension(1, 'VIP');
        $product->setCustomMetric(1, 89);

        $hitBuilder = new HitBuilder();
        $hitBuilder->setClientId('client_id');

        $product->applyTo($hitBuilder);

        self::assertHit(<<<QUERY
            v=1
            &cid=client_id
            &pr1id=product_id_123
            &pr1nm=Product 123
            &pr1br=Cool brand
            &pr1ca=Jeans
            &pr1va=Black
            &pr1pr=213.12
            &pr1qt=2
            &pr1cc=10% off
            &pr1ps=12
            &pr1cd1=VIP
            &pr1cm1=89
            &tid=UA-1234-1
            QUERY, $hitBuilder->getHit('UA-1234-1'));
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function it_applies_product_impression_properties(): void
    {
        $product = Product::createAsProductImpressionType('product_id_123', 'Product 123', 2);
        $product->brand = 'Cool brand';
        $product->variant = 'Black';
        $product->position = 12;
        $product->price = 213.12;
        $product->category = 'Jeans';
        $product->couponCode = '10% off';

        $product->setCustomDimension(1, 'VIP');
        $product->setCustomMetric(1, 89);

        $hitBuilder = new HitBuilder();
        $hitBuilder->setClientId('client_id');

        $product->applyTo($hitBuilder);

        self::assertHit(<<<QUERY
            v=1
            &cid=client_id
            &il2pr1id=product_id_123
            &il2pr1nm=Product 123
            &il2pr1br=Cool brand
            &il2pr1ca=Jeans
            &il2pr1va=Black
            &il2pr1pr=213.12
            &il2pr1cc=10% off
            &il2pr1ps=12
            &il2pr1cd1=VIP
            &il2pr1cm1=89
            &tid=UA-1234-1
            QUERY, $hitBuilder->getHit('UA-1234-1'));
    }

    /**
     * @test
     */
    public function it_throws_if_input_is_out_of_lower_bounds_for_dimension(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $product = Product::createAsProductType('product_id_123', 'Product 123');
        $product->setCustomDimension(0, 'VIP');
    }

    /**
     * @test
     */
    public function it_throws_if_input_is_out_of_upper_bounds_for_dimension(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $product = Product::createAsProductType('product_id_123', 'Product 123');
        $product->setCustomDimension(201, 'VIP');
    }

    /**
     * @test
     */
    public function it_throws_if_input_is_out_of_lower_bounds_for_metric(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $product = Product::createAsProductType('product_id_123', 'Product 123');
        $product->setCustomMetric(0, 123);
    }

    /**
     * @test
     */
    public function it_throws_if_input_is_out_of_upper_bounds_for_metric(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $product = Product::createAsProductType('product_id_123', 'Product 123');
        $product->setCustomMetric(201, 123);
    }
}
