<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Builder;

final class HitBuilderTest extends TestCase
{
    /**
     * @test
     */
    public function it_returns_query(): void
    {
        $builder = new HitBuilder();
        self::assertSame('', $builder->getQuery());
    }

    /**
     * @test
     */
    public function it_returns_query_with_parameters(): void
    {
        // todo create more sane values below
        $builder = new HitBuilder();
        $builder->protocolVersion = '1';
        $builder->measurementId = 'UA-1234-5';
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

        $enhancedEcommerce = new EnhancedEcommerceBuilder();
        $enhancedEcommerce->transactionId = 'transaction123';

        $builder->enhancedEcommerce = $enhancedEcommerce;

        self::assertBuilder(<<<QUERY
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
            &ti=transaction123
            QUERY, $builder);
    }
}
