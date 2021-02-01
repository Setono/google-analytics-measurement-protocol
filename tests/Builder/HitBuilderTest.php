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
        $builder->setProtocolVersion('1');
        $builder->setPropertyId('UA-1234-5');
        $builder->setAnonymizeIP(false);
        $builder->setDataSource('dataSource');
        $builder->setClientId('clientId');
        $builder->setUserId('userId');
        $builder->setIPOverride('IPOverride');
        $builder->setUserAgentOverride('userAgentOverride');
        $builder->setDocumentReferrer('documentReferrer');
        $builder->setCampaignName('campaignName');
        $builder->setCampaignSource('campaignSource');
        $builder->setCampaignMedium('campaignMedium');
        $builder->setCampaignKeyword('campaignKeyword');
        $builder->setCampaignContent('campaignContent');
        $builder->setCampaignId('campaignId');
        $builder->setGoogleAdsId('googleAdsId');
        $builder->setGoogleDisplayAdsId('googleDisplayAdsId');
        $builder->setHitType('hitType');
        $builder->setNonInteractionHit(true);
        $builder->setDocumentLocationUrl('documentLocationUrl');
        $builder->setDocumentHostName('documentHostName');
        $builder->setDocumentPath('documentPath');
        $builder->setDocumentTitle('documentTitle');

        $builder->setProductAction('action');
        $builder->setTransactionId('transaction123');
        $builder->setTransactionAffiliation('google');
        $builder->setTransactionRevenue(123.12);
        $builder->setTransactionShipping(10.5);
        $builder->setTransactionTax(4.3);
        $builder->setTransactionCouponCode('great_coupon');
        $builder->setCheckoutStep(2);
        $builder->setCheckoutStepOption('VISA');
        $builder->setCurrencyCode('USD');

        $product = new ProductBuilder(1);
        $product->sku = 'product_sku_123';

        $builder->addProduct($product);

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
        $builder->setPropertyId('UA-1234-5');
        $builder->store();

        $builder = self::getHitBuilder($storage);
        $builder->restore();

        self::assertSame('UA-1234-5', $builder->getPropertyId());
    }

    private static function getHitBuilder(StorageInterface $storage = null): HitBuilder
    {
        $storage = $storage ?? new InMemoryStorage();

        return new HitBuilder($storage, 'test');
    }
}
