<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Builder;

use Setono\GoogleAnalyticsMeasurementProtocol\Storage\InMemoryStorage;
use Setono\GoogleAnalyticsMeasurementProtocol\Storage\StorageInterface;

final class HitBuilderTest extends TestCase
{
    /**
     * @test
     */
    public function it_returns_query(): void
    {
        $builder = self::getHitBuilder();
        self::assertSame('', $builder->getQuery());
    }

    /**
     * @test
     */
    public function it_returns_query_with_parameters(): void
    {
        // todo create more sane values below
        $builder = self::getHitBuilder();
        $builder->protocolVersion = '1';
        $builder->propertyId = 'UA-1234-5';
        $builder->anonymizeIP = false;
        $builder->dataSource = 'dataSource';
        $builder->clientId = 'clientId';
        $builder->userId = 'userId';
        $builder->IPOverride = 'IPOverride';
        $builder->userAgentOverride = 'userAgentOverride';
        $builder->documentReferrer = 'documentReferrer';
        $builder->campaignName = 'campaignName';
        $builder->campaignSource = 'campaignSource';
        $builder->campaignMedium = 'campaignMedium';
        $builder->campaignKeyword = 'campaignKeyword';
        $builder->campaignContent = 'campaignContent';
        $builder->campaignId = 'campaignId';
        $builder->googleAdsId = 'googleAdsId';
        $builder->googleDisplayAdsId = 'googleDisplayAdsId';
        $builder->hitType = 'hitType';
        $builder->nonInteractionHit = true;
        $builder->documentLocationUrl = 'documentLocationUrl';
        $builder->documentHostName = 'documentHostName';
        $builder->documentPath = 'documentPath';
        $builder->documentTitle = 'documentTitle';

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

        $builder->products[] = $product;

        self::assertBuilderQuery(<<<QUERY
            v=1
            &tid=UA-1234-5
            &aip=0
            &ds=dataSource
            &cid=clientId
            &uid=userId
            &ua=userAgentOverride
            &dr=documentReferrer
            &cn=campaignName
            &cs=campaignSource
            &cm=campaignMedium
            &ck=campaignKeyword
            &cc=campaignContent
            &ci=campaignId
            &gclid=googleAdsId
            &dclid=googleDisplayAdsId
            &t=hitType
            &ni=1
            &dl=documentLocationUrl
            &dh=documentHostName
            &dp=documentPath
            &dt=documentTitle
            &pa=action
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

    /**
     * @test
     */
    public function it_stores_and_restores(): void
    {
        $storage = new InMemoryStorage();

        $builder = self::getHitBuilder($storage);
        $builder->propertyId = 'UA-1234-5';
        $builder->store();

        $builder = self::getHitBuilder($storage);
        $builder->restore();

        self::assertSame('UA-1234-5', $builder->propertyId);
    }

    private static function getHitBuilder(StorageInterface $storage = null): HitBuilder
    {
        $storage = $storage ?? new InMemoryStorage();

        return new HitBuilder($storage, 'test');
    }
}
