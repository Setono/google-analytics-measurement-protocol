<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Hit;

use PHPUnit\Framework\TestCase;
use Setono\GoogleAnalyticsMeasurementProtocol\DTO\ProductData;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\RequestInterface;
use Setono\GoogleAnalyticsMeasurementProtocol\Response\ResponseInterface;

/**
 * @covers \Setono\GoogleAnalyticsMeasurementProtocol\Hit\HitBuilder
 */
final class HitBuilderTest extends TestCase
{
    /**
     * @test
     * @runInSeparateProcess
     *
     * The reason we need to run in a separate process is that the Product DTO has a static index variable
     */
    public function it_generates_payload(): void
    {
        // todo create more sane values below
        $builder = self::getHitBuilder();
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
        $builder->setHitType(HitBuilderInterface::HIT_TYPE_PAGEVIEW);
        $builder->setNonInteractionHit(true);
        $builder->setDocumentLocationUrl('documentLocationUrl');
        $builder->setDocumentHostName('documentHostName');
        $builder->setDocumentPath('documentPath');
        $builder->setDocumentTitle('documentTitle');

        $builder->setProductAction('detail');
        $builder->setTransactionId('transaction123');
        $builder->setTransactionAffiliation('google');
        $builder->setTransactionRevenue(123.12);
        $builder->setTransactionShipping(10.5);
        $builder->setTransactionTax(4.3);
        $builder->setTransactionCouponCode('great_coupon');
        $builder->setCheckoutStep(2);
        $builder->setCheckoutStepOption('VISA');
        $builder->setCurrencyCode('USD');

        $product = ProductData::createAsProductType('product_sku_123', 'Product 123');
        $product->applyTo($builder);

        $expectedData = [
            'v' => '1',
            't' => 'pageview',
            'aip' => false,
            'ds' => 'dataSource',
            'cid' => 'clientId',
            'uid' => 'userId',
            'uip' => '64.12.12.56',
            'ua' => 'userAgentOverride',
            'dr' => 'documentReferrer',
            'cn' => 'campaignName',
            'cs' => 'campaignSource',
            'cm' => 'campaignMedium',
            'ck' => 'campaignKeyword',
            'cc' => 'campaignContent',
            'ci' => 'campaignId',
            'gclid' => 'googleAdsId',
            'dclid' => 'googleDisplayAdsId',
            'ni' => true,
            'dl' => 'documentLocationUrl',
            'dh' => 'documentHostName',
            'dp' => 'documentPath',
            'dt' => 'documentTitle',
            'pa' => 'detail',
            'ti' => 'transaction123',
            'ta' => 'google',
            'tr' => 123.12,
            'ts' => 10.5,
            'tt' => 4.3,
            'tcc' => 'great_coupon',
            'cos' => 2,
            'col' => 'VISA',
            'cu' => 'USD',
            'pr1id' => 'product_sku_123',
            'pr1nm' => 'Product 123',
            'tid' => 'UA-1234-1',
        ];

        self::assertEquals($expectedData, $builder->getHit('UA-1234-1')->getData());
    }

    /**
     * @test
     */
    public function it_sets_hit_type_to_pageview_by_default(): void
    {
        $builder = self::getHitBuilder();
        self::assertSame(HitBuilderInterface::HIT_TYPE_PAGEVIEW, $builder->getHitType());
    }

    /**
     * @test
     */
    public function it_gets_and_sets(): void
    {
        $reflectionClass = new \ReflectionClass(HitBuilder::class);
        $builder = self::getHitBuilder();

        $properties = [
            'anonymizeIp',
            'dataSource',
            'clientId',
            'userId',
            'ipOverride',
            'userAgentOverride',
            'documentReferrer',
            'campaignName',
            'campaignSource',
            'campaignMedium',
            'campaignKeyword',
            'campaignContent',
            'campaignId',
            'googleAdsId',
            'googleDisplayAdsId',
            'nonInteractionHit',
            'documentLocationUrl',
            'documentHostName',
            'documentPath',
            'documentTitle',
            'eventCategory',
            'eventAction',
            'eventLabel',
            'eventValue',
            'productAction',
            'transactionId',
            'transactionAffiliation',
            'transactionRevenue',
            'transactionShipping',
            'transactionTax',
            'transactionCouponCode',
            'checkoutStep',
            'checkoutStepOption',
            'currencyCode',
        ];

        $typeMapping = [
            'string' => 'detail',
            'bool' => false,
            'int' => 123,
            'float' => 123.45,
        ];

        foreach ($properties as $property) {
            $setMethodName = 'set' . ucfirst($property);
            self::assertTrue($reflectionClass->hasMethod($setMethodName));

            $getMethodName = 'get' . ucfirst($property);
            if (!$reflectionClass->hasMethod($getMethodName)) {
                $getMethodName = 'is' . ucfirst($property);
            }
            self::assertTrue($reflectionClass->hasMethod($getMethodName));
            self::assertNull($builder->{$getMethodName}());

            $reflectionMethod = $reflectionClass->getMethod($setMethodName);
            $parameters = $reflectionMethod->getParameters();
            self::assertCount(1, $parameters);

            $type = $parameters[0]->getType()->getName();

            self::assertArrayHasKey($type, $typeMapping);

            $val = $typeMapping[$type];

            $builder->{$setMethodName}($val);
            self::assertSame($val, $builder->{$getMethodName}());
        }
    }

    /**
     * @test
     */
    public function it_unsets_properties_for_null_input(): void
    {
        $hitBuilder = self::getHitBuilder();
        $hitBuilder->setProductName('Product 123', 3);
        self::assertArrayHasKey('pr3nm', $hitBuilder->getData());

        $hitBuilder->setProductImpressionName('Product 123', 3, 4);
        self::assertArrayHasKey('il4pr3nm', $hitBuilder->getData());

        $hitBuilder->setProductCustomMetric(123.45, 2, 3);
        self::assertArrayHasKey('pr3cm2', $hitBuilder->getData());

        $hitBuilder->setProductCustomDimension('VIP', 2, 3);
        self::assertArrayHasKey('pr3cd2', $hitBuilder->getData());

        $hitBuilder->setProductImpressionCustomMetric(123.45, 2, 3, 4);
        self::assertArrayHasKey('il4pr3cm2', $hitBuilder->getData());

        $hitBuilder->setProductImpressionCustomDimension('Importante', 2, 3, 4);
        self::assertArrayHasKey('il4pr3cd2', $hitBuilder->getData());

        $hitBuilder->setProductName(null, 3);
        $hitBuilder->setProductImpressionName(null, 3, 4);
        $hitBuilder->setProductCustomMetric(null, 2, 3);
        $hitBuilder->setProductCustomDimension(null, 2, 3);
        $hitBuilder->setProductImpressionCustomMetric(null, 2, 3, 4);
        $hitBuilder->setProductImpressionCustomDimension(null, 2, 3, 4);

        self::assertArrayNotHasKey('pr3nm', $hitBuilder->getData());
        self::assertArrayNotHasKey('il4pr3nm', $hitBuilder->getData());
        self::assertArrayNotHasKey('pr3cm2', $hitBuilder->getData());
        self::assertArrayNotHasKey('pr3cd2', $hitBuilder->getData());
        self::assertArrayNotHasKey('il4pr3cm2', $hitBuilder->getData());
        self::assertArrayNotHasKey('il4pr3cd2', $hitBuilder->getData());
    }

    /**
     * @test
     */
    public function it_throws_if_product_custom_metric_does_not_get_right_input(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $hitBuilder = self::getHitBuilder();
        $hitBuilder->setProductCustomMetric('string', 1, 1);
    }

    /**
     * @test
     */
    public function it_throws_if_product_impression_custom_metric_does_not_get_right_input(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $hitBuilder = self::getHitBuilder();
        $hitBuilder->setProductImpressionCustomMetric('string', 1, 1, 1);
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
                if ('utm_term' === $parameter) {
                    return null;
                }

                return $parameter;
            }

            public function getReferrer(): ?string
            {
                return 'https://www.google.com';
            }

            public function getLanguage(): ?string
            {
                return 'en';
            }
        };
        $builder = self::getHitBuilder();
        $builder->setClientId('client_id');
        $builder->populateFromRequest($request);

        $expectedData = [
            'v' => '1',
            't' => 'pageview',
            'cid' => 'client_id',
            'dl' => 'https://example.com',
            'ua' => 'Chrome',
            'uip' => '10.11.12.13',
            'dr' => 'https://www.google.com',
            'cn' => 'utm_campaign',
            'cc' => 'utm_content',
            'cm' => 'utm_medium',
            'cs' => 'utm_source',
            'gclid' => 'gclid',
            'dclid' => 'dclid',
            'tid' => 'UA-1234-1',
            'ul' => 'en',
        ];

        self::assertEquals($expectedData, $builder->getHit('UA-1234-1')->getData());
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
        $builder->setClientId('client_id');
        $builder->populateFromResponse($response);

        $expectedData = [
            'v' => '1',
            't' => 'pageview',
            'cid' => 'client_id',
            'dt' => 'Homepage',
            'tid' => 'UA-1234-1',
        ];

        self::assertEquals($expectedData, $builder->getHit('UA-1234-1')->getData());
    }

    /**
     * @test
     */
    public function it_throws_exception_if_client_id_is_not_set(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The client id is mandatory when generating a hit');

        self::getHitBuilder()->getHit('UA-1234-1');
    }

    private static function getHitBuilder(): HitBuilderInterface
    {
        return new HitBuilder(HitBuilderInterface::HIT_TYPE_PAGEVIEW);
    }
}
