<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Builder;

final class EnhancedEcommerceBuilderTest extends TestCase
{
    /**
     * @test
     */
    public function it_returns_query(): void
    {
        $builder = new EnhancedEcommerceBuilder();
        self::assertSame('', $builder->getQuery());
    }

    /**
     * @test
     */
    public function it_returns_query_with_parameters(): void
    {
        $builder = new EnhancedEcommerceBuilder();
        $builder->productAction = 'action';
        $builder->transactionId = 'transaction123';
        $builder->transactionAffiliation = 'google';
        $builder->transactionRevenue = 123.12;
        $builder->transactionShipping = 10.5;
        $builder->transactionTax = 4.3;
        $builder->transactionCouponCode = 'great_coupon';
        $builder->checkoutStep = 2;
        $builder->checkoutStepOption = 'VISA';
        $builder->currencyCode = 'USD';

        $product = new ProductBuilder(1);
        $product->sku = 'product_sku_123';

        $builder->addProduct($product);

        self::assertBuilder(<<<QUERY
            pa=action
            &ti=transaction123
            &ta=google
            &tr=123.12
            &ts=10.5
            &tt=4.3
            &tcc=great_coupon
            &cos=2
            &col=VISA
            &cu=USD
            &pr1id=product_sku_123
            QUERY, $builder);
    }
}
