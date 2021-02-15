<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Builder;

use Setono\GoogleAnalyticsMeasurementProtocol\Hit\Hit;
use Setono\GoogleAnalyticsMeasurementProtocol\Hit\Payload;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\RequestInterface;
use Setono\GoogleAnalyticsMeasurementProtocol\Response\ResponseInterface;
use Setono\GoogleAnalyticsMeasurementProtocol\Storage\StorageInterface;
use Webmozart\Assert\Assert;

/**
 * @method string|null getProtocolVersion()
 * @method self setProtocolVersion(string $protocolVersion)
 * @method bool|null isAnonymizeIp()
 * @method self setAnonymizeIp(bool $anonymizeIp)
 * @method string|null getDataSource()
 * @method self setDataSource(string $dataSource)
 * @method string|null getClientId()
 * @method self setClientId(string $clientId)
 * @method string|null getUserId()
 * @method self setUserId(string $userId)
 * @method string|null getIpOverride()
 * @method self setIpOverride(string $ipOverride)
 * @method string|null getUserAgentOverride()
 * @method self setUserAgentOverride(string $userAgentOverride)
 * @method string|null getDocumentReferrer()
 * @method self setDocumentReferrer(string $documentReferrer)
 * @method string|null getCampaignName()
 * @method self setCampaignName(string $campaignName)
 * @method string|null getCampaignSource()
 * @method self setCampaignSource(string $campaignSource)
 * @method string|null getCampaignMedium()
 * @method self setCampaignMedium(string $campaignMedium)
 * @method string|null getCampaignKeyword()
 * @method self setCampaignKeyword(string $campaignKeyword)
 * @method string|null getCampaignContent()
 * @method self setCampaignContent(string $campaignContent)
 * @method string|null getCampaignId()
 * @method self setCampaignId(string $campaignId)
 * @method string|null getGoogleAdsId()
 * @method self setGoogleAdsId(string $googleAdsId)
 * @method string|null getGoogleDisplayAdsId()
 * @method self setGoogleDisplayAdsId(string $googleDisplayAdsId)
 * @method string|null getHitType()
 * @method self setHitType(string $hitType)
 * @method bool|null isNonInteractionHit()
 * @method self setNonInteractionHit(bool $nonInteractionHit)
 * @method string|null getDocumentLocationUrl()
 * @method self setDocumentLocationUrl(string $documentLocationUrl)
 * @method string|null getDocumentHostName()
 * @method self setDocumentHostName(string $documentHostName)
 * @method string|null getDocumentPath()
 * @method self setDocumentPath(string $documentPath)
 * @method string|null getDocumentTitle()
 * @method self setDocumentTitle(string $documentTitle)
 * @method string|null getProductAction()
 * @method self setProductAction(string $productAction)
 * @method string|null getTransactionId()
 * @method self setTransactionId(string $transactionId)
 * @method string|null getTransactionAffiliation()
 * @method self setTransactionAffiliation(string $transactionAffiliation)
 * @method float|null getTransactionRevenue()
 * @method self setTransactionRevenue(float $transactionRevenue)
 * @method float|null getTransactionShipping()
 * @method self setTransactionShipping(float $transactionShipping)
 * @method float|null getTransactionTax()
 * @method self setTransactionTax(float $transactionTax)
 * @method string|null getTransactionCouponCode()
 * @method self setTransactionCouponCode(string $transactionCouponCode)
 * @method int|null getCheckoutStep()
 * @method self setCheckoutStep(int $checkoutStep)
 * @method string|null getCheckoutStepOption()
 * @method self setCheckoutStepOption(string $checkoutStepOption)
 * @method string|null getCurrencyCode()
 * @method self setCurrencyCode(string $currencyCode)
 */
final class HitBuilder extends PayloadBuilder
{
    /**
     * Instead of having a single property we support multiple properties out of the box
     *
     * @var array<array-key, string>
     */
    private array $properties = [];

    /** @var array<array-key, ProductBuilder> */
    private array $products = [];

    private ?StorageInterface $storage = null;

    private ?string $storageKey = null;

    /**
     * @param array<array-key, string> $properties
     */
    public function __construct(array $properties)
    {
        foreach ($properties as $property) {
            $this->addProperty($property);
        }

        $this->setProtocolVersion('1');
    }

    /**
     * @return array<array-key, Hit>
     */
    public function getHits(): array
    {
        $hits = [];

        $clientId = $this->getClientId();
        Assert::string($clientId, 'You have to set a client id to retrieve the hits');

        foreach ($this->properties as $property) {
            $payload = $this->getPayload($property);

            $hits[] = new Hit($property, $clientId, $payload);
        }

        return $hits;
    }

    public function getPayload(string $propertyId): Payload
    {
        $payload = $this->buildPayload();
        $payload->set('tid', $propertyId);

        foreach ($this->products as $productBuilder) {
            $payload->mergePayload($productBuilder->getPayload());
        }

        return $payload;
    }

    public function populateFromRequest(RequestInterface $request): void
    {
        $this->setDocumentLocationUrl($request->getUrl());
        $this->setUserAgentOverride($request->getUserAgent());
        $this->setIpOverride($request->getIp());

        $referrer = $request->getReferrer();
        if (null !== $referrer) {
            $this->setDocumentReferrer($referrer);
        }

        $mapping = [
            'utm_campaign' => 'campaignName',
            'utm_content' => 'campaignContent',
            'utm_medium' => 'campaignMedium',
            'utm_source' => 'campaignSource',
            'utm_term' => 'campaignKeyword',
            'gclid' => 'googleAdsId',
            'dclid' => 'googleDisplayAdsId',
        ];

        foreach ($mapping as $queryParameter => $property) {
            $val = $request->getQueryValue($queryParameter);
            if (null === $val) {
                continue;
            }

            $this->set($property, $val);
        }
    }

    public function populateFromResponse(ResponseInterface $response): void
    {
        $title = $response->getTitle();
        if (null !== $title) {
            $this->setDocumentTitle($title);
        }
    }

    public function store(): void
    {
        if (null === $this->storage || null === $this->storageKey) {
            return;
        }

        $data = [
            'data' => $this->data,
            'products' => $this->products,
            'properties' => $this->properties,
        ];

        $this->storage->store($this->storageKey, serialize($data));
    }

    public function restore(): void
    {
        if (null === $this->storage || null === $this->storageKey) {
            return;
        }

        $stored = $this->storage->restore($this->storageKey);
        if (null === $stored || '' === $stored) {
            return;
        }

        /** @var array{data: array<string, scalar>, products: array<array-key, ProductBuilder>, properties: array<array-key, string>} $data */
        $data = unserialize($stored, ['allowed_classes' => false]);

        /**
         * @var string $key
         * @var scalar $val
         */
        foreach ($data['data'] as $key => $val) {
            $this->set($key, $val);
        }

        $this->setProducts($data['products']);

        /** @var string $property */
        foreach ($data['properties'] as $property) {
            $this->addProperty($property);
        }
    }

    public function setStorage(StorageInterface $storage, string $storageKey): void
    {
        $this->storage = $storage;
        $this->storageKey = $storageKey;
    }

    public function getProperties(): array
    {
        return $this->properties;
    }

    private function addProperty(string $property): void
    {
        $this->properties[] = $property;
    }

    /**
     * @return ProductBuilder[]
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    /**
     * @param ProductBuilder[] $products
     */
    public function setProducts(array $products): self
    {
        foreach ($products as $product) {
            $this->addProduct($product);
        }

        return $this;
    }

    public function addProduct(ProductBuilder $product): self
    {
        $this->products[] = $product;

        return $this;
    }

    protected function getPropertyMapping(): array
    {
        return [
            'v' => 'protocolVersion',
            'tid' => 'propertyId',
            'aip' => 'anonymizeIp',
            'ds' => 'dataSource',
            'cid' => 'clientId',
            'uid' => 'userId',
            'uip' => 'ipOverride',
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
            't' => 'hitType',
            'ni' => 'nonInteractionHit',
            'dl' => 'documentLocationUrl',
            'dh' => 'documentHostName',
            'dp' => 'documentPath',
            'dt' => 'documentTitle',

            // Enhanced ecommerce property mapping
            'pa' => 'productAction',
            'ti' => 'transactionId',
            'ta' => 'transactionAffiliation',
            'tr' => 'transactionRevenue',
            'ts' => 'transactionShipping',
            'tt' => 'transactionTax',
            'tcc' => 'transactionCouponCode',
            'cos' => 'checkoutStep',
            'col' => 'checkoutStepOption',
            'cu' => 'currencyCode',
        ];
    }
}
