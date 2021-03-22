<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\DTO;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Setono\GoogleAnalyticsMeasurementProtocol\DTO\Product
 */
class ProductTest extends TestCase
{
    /**
     * @test
     */
    public function it_generates_data(): void
    {
        $product = new Product('product_id_123', 'Product 123');
        $product->brand = 'Cool brand';
        $product->variant = 'Black';
        $product->position = 12;
        $product->price = 213.12;
        $product->category = 'Jeans';
        $product->quantity = 2;
        $product->couponCode = '10% off';

        $product->setCustomDimension(1, 'VIP');
        $product->setCustomMetric(1, 89);

        $expected = [
            'pr1id' => 'product_id_123',
            'pr1nm' => 'Product 123',
            'pr1br' => 'Cool brand',
            'pr1va' => 'Black',
            'pr1ps' => 12,
            'pr1pr' => 213.12,
            'pr1ca' => 'Jeans',
            'pr1qt' => 2,
            'pr1cc' => '10% off',
            'pr1cd1' => 'VIP',
            'pr1cm1' => 89,
        ];

        self::assertEquals($expected, $product->generateData('pr1'));
    }

    /**
     * @test
     */
    public function it_throws_if_input_is_out_of_lower_bounds_for_dimension(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $product = new Product('product_id_123', 'Product 123');
        $product->setCustomDimension(0, 'VIP');
    }

    /**
     * @test
     */
    public function it_throws_if_input_is_out_of_upper_bounds_for_dimension(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $product = new Product('product_id_123', 'Product 123');
        $product->setCustomDimension(201, 'VIP');
    }

    /**
     * @test
     */
    public function it_throws_if_input_is_out_of_lower_bounds_for_metric(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $product = new Product('product_id_123', 'Product 123');
        $product->setCustomMetric(0, 123);
    }

    /**
     * @test
     */
    public function it_throws_if_input_is_out_of_upper_bounds_for_metric(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $product = new Product('product_id_123', 'Product 123');
        $product->setCustomMetric(201, 123);
    }
}
