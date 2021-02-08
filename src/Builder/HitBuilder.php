<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Builder;

use Setono\GoogleAnalyticsMeasurementProtocol\Hit\Hit;
use Setono\GoogleAnalyticsMeasurementProtocol\Hit\Payload;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\RequestInterface;
use Setono\GoogleAnalyticsMeasurementProtocol\Response\ResponseInterface;
use Setono\GoogleAnalyticsMeasurementProtocol\Storage\StorageInterface;

/**
 * @method string getProtocolVersion()
 * @method self setProtocolVersion(string $protocolVersion)
 * @method bool isAnonymizeIp()
 * @method self setAnonymizeIp(bool $anonymizeIp)
 * @method string getDataSource()
 * @method self setDataSource(string $dataSource)
 * @method string getClientId()
 * @method self setClientId(string $clientId)
 * @method string getUserId()
 * @method self setUserId(string $userId)
 * @method string getIpOverride()
 * @method self setIpOverride(string $ipOverride)
 * @method string getUserAgentOverride()
 * @method self setUserAgentOverride(string $userAgentOverride)
 * @method string getDocumentReferrer()
 * @method self setDocumentReferrer(string $documentReferrer)
 * @method string getCampaignName()
 * @method self setCampaignName(string $campaignName)
 * @method string getCampaignSource()
 * @method self setCampaignSource(string $campaignSource)
 * @method string getCampaignMedium()
 * @method self setCampaignMedium(string $campaignMedium)
 * @method string getCampaignKeyword()
 * @method self setCampaignKeyword(string $campaignKeyword)
 * @method string getCampaignContent()
 * @method self setCampaignContent(string $campaignContent)
 * @method string getCampaignId()
 * @method self setCampaignId(string $campaignId)
 * @method string getGoogleAdsId()
 * @method self setGoogleAdsId(string $googleAdsId)
 * @method string getGoogleDisplayAdsId()
 * @method self setGoogleDisplayAdsId(string $googleDisplayAdsId)
 * @method string getHitType()
 * @method self setHitType(string $hitType)
 * @method bool isNonInteractionHit()
 * @method self setNonInteractionHit(bool $nonInteractionHit)
 * @method string getDocumentLocationUrl()
 * @method self setDocumentLocationUrl(string $documentLocationUrl)
 * @method string getDocumentHostName()
 * @method self setDocumentHostName(string $documentHostName)
 * @method string getDocumentPath()
 * @method self setDocumentPath(string $documentPath)
 * @method string getDocumentTitle()
 * @method self setDocumentTitle(string $documentTitle)
 * @method string getProductAction()
 * @method self setProductAction(string $productAction)
 * @method string getTransactionId()
 * @method self setTransactionId(string $transactionId)
 * @method string getTransactionAffiliation()
 * @method self setTransactionAffiliation(string $transactionAffiliation)
 * @method float getTransactionRevenue()
 * @method self setTransactionRevenue(float $transactionRevenue)
 * @method float getTransactionShipping()
 * @method self setTransactionShipping(float $transactionShipping)
 * @method float getTransactionTax()
 * @method self setTransactionTax(float $transactionTax)
 * @method string getTransactionCouponCode()
 * @method self setTransactionCouponCode(string $transactionCouponCode)
 * @method int getCheckoutStep()
 * @method self setCheckoutStep(int $checkoutStep)
 * @method string getCheckoutStepOption()
 * @method self setCheckoutStepOption(string $checkoutStepOption)
 * @method string getCurrencyCode()
 * @method self setCurrencyCode(string $currencyCode)
 */
final class HitBuilder extends PayloadBuilder
{
    /**
     * Instead of having a single property we support multiple properties out of the box
     *
     * @var array<array-key, string>
     */
    private array $propertyIds = [];

    /** @var array<array-key, ProductBuilder> */
    private array $products = [];

    private StorageInterface $storage;

    private string $storageKey;

    public function __construct(StorageInterface $storage, string $storageKey)
    {
        $this->storage = $storage;
        $this->storageKey = $storageKey;
    }

    /**
     * @return array<array-key, Hit>
     */
    public function getHits(): array
    {
        $hits = [];

        foreach ($this->propertyIds as $propertyId) {
            $payload = $this->getPayload($propertyId);

            $hits[] = new Hit($propertyId, $this->getClientId(), $payload);
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

            $this->{'set' . ucfirst($property)}($val);
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
        $data = [
            'properties' => $this->data,
            'products' => $this->products,
            'propertyIds' => $this->propertyIds,
        ];

        $this->storage->store($this->storageKey, serialize($data));
    }

    public function restore(): void
    {
        $stored = $this->storage->restore($this->storageKey);
        if (null === $stored) {
            return;
        }

        /** @var array{properties: array<string, scalar>, products: array<array-key, ProductBuilder>, propertyIds: array<array-key, string>} $data */
        $data = unserialize($stored, ['allowed_classes' => false]);

        $this->data = $data['properties'];
        $this->products = $data['products'];
        $this->propertyIds = $data['propertyIds'];
    }

    public function getPropertyIds(): array
    {
        return $this->propertyIds;
    }

    public function addPropertyId(string $propertyId): self
    {
        $this->propertyIds[] = $propertyId;

        return $this;
    }

    public function removePropertyId(string $propertyId): self
    {
        $key = array_search($propertyId, $this->propertyIds, true);
        if (false === $key) {
            return $this;
        }

        unset($this->propertyIds[$key]);

        return $this;
    }

    /**
     * @param array<array-key, string> $propertyIds
     */
    public function setPropertyIds(array $propertyIds): self
    {
        $this->propertyIds = $propertyIds;

        return $this;
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
        $this->products = $products;

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
