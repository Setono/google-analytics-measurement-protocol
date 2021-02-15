<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Builder;

use Setono\GoogleAnalyticsMeasurementProtocol\Hit\Hit;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\RequestInterface;
use Setono\GoogleAnalyticsMeasurementProtocol\Response\ResponseInterface;
use Setono\GoogleAnalyticsMeasurementProtocol\Storage\InMemoryStorage;
use Setono\GoogleAnalyticsMeasurementProtocol\Storage\StorageInterface;

/**
 * @covers \Setono\GoogleAnalyticsMeasurementProtocol\Builder\HitBuilder
 * @covers \Setono\GoogleAnalyticsMeasurementProtocol\Builder\PayloadBuilder
 */
final class HitBuilderTest extends TestCase
{
    /**
     * @test
     */
    public function it_generates_payload(): void
    {
        // todo create more sane values below
        $builder = self::getHitBuilder();
        $builder->setProtocolVersion('1');
        $builder->setAnonymizeIp(false);
        $builder->setDataSource('dataSource');
        $builder->setClientId('clientId');
        $builder->setUserId('userId');
        $builder->setIpOverride('64.12.12.56');
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
        $product->setSku('product_sku_123');

        $builder->addProduct($product);

        self::assertPayload(<<<QUERY
            v=1
            &aip=0
            &ds=dataSource
            &cid=clientId
            &uid=userId
            &uip=64.12.12.56
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
            &tid=UA-1234-5
            &pr1id=product_sku_123
            QUERY, $builder->getPayload('UA-1234-5'));
    }

    /**
     * @test
     */
    public function it_gets_and_sets(): void
    {
        $builder = self::getHitBuilder();
        $builder->setClientId('clientId');

        $product1 = new ProductBuilder(1);
        $product1->setSku('product_sku_1');

        $product2 = new ProductBuilder(1);
        $product2->setSku('product_sku_2');

        $builder->setProducts([$product1, $product2]);

        self::assertSame('clientId', $builder->getClientId());
        self::assertSame([$product1, $product2], $builder->getProducts());
        self::assertSame(['UA-1234-5'], $builder->getProperties());
    }

    /**
     * @test
     */
    public function it_gets_hits(): void
    {
        $builder = self::getHitBuilder();
        $builder->setClientId('clientId');

        $hits = $builder->getHits();
        foreach ($hits as $hit) {
            self::assertInstanceOf(Hit::class, $hit);
            self::assertSame('UA-1234-5', $hit->getPropertyId());
            self::assertSame('clientId', $hit->getClientId());

            $payload = $hit->getPayload();
            self::assertSame('v=1&cid=clientId&tid=UA-1234-5', $payload->getValue());
        }
    }

    /**
     * @test
     */
    public function it_populates_from_request(): void
    {
        $request = new class() implements RequestInterface {
            public function getUrl(): string
            {
                return 'https://example.com';
            }

            public function getUserAgent(): string
            {
                return 'Chrome';
            }

            public function getIp(): string
            {
                return '10.11.12.13';
            }

            public function getQueryValue(string $parameter): ?string
            {
                if ('dclid' === $parameter) {
                    return null;
                }

                return $parameter;
            }

            public function getReferrer(): ?string
            {
                return 'https://www.google.com';
            }
        };
        $builder = self::getHitBuilder();
        $builder->populateFromRequest($request);

        self::assertPayload(<<<QUERY
            v=1
            &uip=10.11.12.13
            &ua=Chrome
            &dr=https://www.google.com
            &cn=utm_campaign
            &cs=utm_source
            &cm=utm_medium
            &ck=utm_term
            &cc=utm_content
            &gclid=gclid
            &dl=https://example.com
            &tid=UA-1234-5
            QUERY, $builder->getPayload('UA-1234-5'));
    }

    /**
     * @test
     */
    public function it_populates_from_response(): void
    {
        $response = new class() implements ResponseInterface {
            public function getTitle(): ?string
            {
                return 'Homepage';
            }
        };
        $builder = self::getHitBuilder();
        $builder->populateFromResponse($response);

        self::assertPayload('v=1&dt=Homepage&tid=UA-1234-5', $builder->getPayload('UA-1234-5'));
    }

    /**
     * @test
     */
    public function it_throws_exception_if_client_id_is_not_set(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('You have to set a client id to retrieve the hits');

        self::getHitBuilder()->getHits();
    }

    /**
     * @test
     */
    public function it_throws_exception_if_the_property_is_not_valid(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The property "nonExistingProperty" does not exist on this payload builder');

        $builder = self::getHitBuilder();
        $builder->setNonExistingProperty('test');
    }

    /**
     * @test
     */
    public function it_throws_exception_if_accessor_method_does_not_match(): void
    {
        $this->expectException(\BadMethodCallException::class);
        $this->expectExceptionMessage('The method "hasClientId" is not implemented. Use either setClientId or getClientId');

        $builder = self::getHitBuilder();
        $builder->hasClientId();
    }

    /**
     * @test
     */
    public function it_stores_and_restores(): void
    {
        $storage = new InMemoryStorage();

        $builder = self::getHitBuilder($storage);
        $builder->setIpOverride('10.11.12.13');
        $builder->store();

        $builder = self::getHitBuilder($storage);
        $builder->restore();

        self::assertSame('10.11.12.13', $builder->getIpOverride());
    }

    /**
     * @test
     */
    public function it_does_not_store_if_storage_service_is_null(): void
    {
        $builder = self::getHitBuilder();
        $builder->setIpOverride('10.11.12.13');
        $builder->store();

        $builder = self::getHitBuilder();
        $builder->restore();

        self::assertNull($builder->getIpOverride());
    }

    /**
     * @test
     */
    public function it_does_not_restore_if_data_is_empty(): void
    {
        $storage = new InMemoryStorage();
        $builder = self::getHitBuilder($storage);
        $builder->setIpOverride('10.11.12.13');
        $builder->store();

        $storage->store('test', '');

        $builder->restore();

        self::assertSame('10.11.12.13', $builder->getIpOverride());
    }

    private static function getHitBuilder(StorageInterface $storage = null): HitBuilder
    {
        $hitBuilder = new HitBuilder(['UA-1234-5']);

        if (null !== $storage) {
            $hitBuilder->setStorage($storage, 'test');
        }

        return $hitBuilder;
    }
}
