<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Builder;

/**
 * This trait holds all parameters available: https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters
 *
 * @mixin HitBuilderInterface
 */
trait HitBuilderTrait
{
    protected string $protocolVersion;

    protected string $propertyId;

    protected bool $anonymizeIP;

    protected string $dataSource;

    protected string $clientId;

    protected string $userId;

    protected string $IPOverride;

    protected string $userAgentOverride;

    protected string $documentReferrer;

    protected string $campaignName;

    protected string $campaignSource;

    protected string $campaignMedium;

    protected string $campaignKeyword;

    protected string $campaignContent;

    protected string $campaignId;

    protected string $googleAdsId;

    protected string $googleDisplayAdsId;

    protected string $hitType;

    protected bool $nonInteractionHit;

    protected string $documentLocationUrl;

    protected string $documentHostName;

    protected string $documentPath;

    protected string $documentTitle;

    /**
     * Enhanced ecommerce properties
     */
    protected string $productAction;

    protected string $transactionId;

    protected string $transactionAffiliation;

    protected float $transactionRevenue;

    protected float $transactionShipping;

    protected float $transactionTax;

    protected string $transactionCouponCode;

    protected int $checkoutStep;

    protected string $checkoutStepOption;

    protected string $currencyCode;

    /** @var array<array-key, ProductBuilder> */
    protected array $products = [];

    public function getProtocolVersion(): string
    {
        return $this->protocolVersion;
    }

    public function setProtocolVersion(string $protocolVersion): self
    {
        $this->protocolVersion = $protocolVersion;

        return $this;
    }

    public function getPropertyId(): string
    {
        return $this->propertyId;
    }

    public function setPropertyId(string $propertyId): self
    {
        $this->propertyId = $propertyId;

        return $this;
    }

    public function isAnonymizeIP(): bool
    {
        return $this->anonymizeIP;
    }

    public function setAnonymizeIP(bool $anonymizeIP): self
    {
        $this->anonymizeIP = $anonymizeIP;

        return $this;
    }

    public function getDataSource(): string
    {
        return $this->dataSource;
    }

    public function setDataSource(string $dataSource): self
    {
        $this->dataSource = $dataSource;

        return $this;
    }

    public function getClientId(): string
    {
        return $this->clientId;
    }

    public function setClientId(string $clientId): self
    {
        $this->clientId = $clientId;

        return $this;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function setUserId(string $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getIPOverride(): string
    {
        return $this->IPOverride;
    }

    public function setIPOverride(string $IPOverride): self
    {
        $this->IPOverride = $IPOverride;

        return $this;
    }

    public function getUserAgentOverride(): string
    {
        return $this->userAgentOverride;
    }

    public function setUserAgentOverride(string $userAgentOverride): self
    {
        $this->userAgentOverride = $userAgentOverride;

        return $this;
    }

    public function getDocumentReferrer(): string
    {
        return $this->documentReferrer;
    }

    public function setDocumentReferrer(string $documentReferrer): self
    {
        $this->documentReferrer = $documentReferrer;

        return $this;
    }

    public function getCampaignName(): string
    {
        return $this->campaignName;
    }

    public function setCampaignName(string $campaignName): self
    {
        $this->campaignName = $campaignName;

        return $this;
    }

    public function getCampaignSource(): string
    {
        return $this->campaignSource;
    }

    public function setCampaignSource(string $campaignSource): self
    {
        $this->campaignSource = $campaignSource;

        return $this;
    }

    public function getCampaignMedium(): string
    {
        return $this->campaignMedium;
    }

    public function setCampaignMedium(string $campaignMedium): self
    {
        $this->campaignMedium = $campaignMedium;

        return $this;
    }

    public function getCampaignKeyword(): string
    {
        return $this->campaignKeyword;
    }

    public function setCampaignKeyword(string $campaignKeyword): self
    {
        $this->campaignKeyword = $campaignKeyword;

        return $this;
    }

    public function getCampaignContent(): string
    {
        return $this->campaignContent;
    }

    public function setCampaignContent(string $campaignContent): self
    {
        $this->campaignContent = $campaignContent;

        return $this;
    }

    public function getCampaignId(): string
    {
        return $this->campaignId;
    }

    public function setCampaignId(string $campaignId): self
    {
        $this->campaignId = $campaignId;

        return $this;
    }

    public function getGoogleAdsId(): string
    {
        return $this->googleAdsId;
    }

    public function setGoogleAdsId(string $googleAdsId): self
    {
        $this->googleAdsId = $googleAdsId;

        return $this;
    }

    public function getGoogleDisplayAdsId(): string
    {
        return $this->googleDisplayAdsId;
    }

    public function setGoogleDisplayAdsId(string $googleDisplayAdsId): self
    {
        $this->googleDisplayAdsId = $googleDisplayAdsId;

        return $this;
    }

    public function getHitType(): string
    {
        return $this->hitType;
    }

    public function setHitType(string $hitType): self
    {
        $this->hitType = $hitType;

        return $this;
    }

    public function isNonInteractionHit(): bool
    {
        return $this->nonInteractionHit;
    }

    public function setNonInteractionHit(bool $nonInteractionHit): self
    {
        $this->nonInteractionHit = $nonInteractionHit;

        return $this;
    }

    public function getDocumentLocationUrl(): string
    {
        return $this->documentLocationUrl;
    }

    public function setDocumentLocationUrl(string $documentLocationUrl): self
    {
        $this->documentLocationUrl = $documentLocationUrl;

        return $this;
    }

    public function getDocumentHostName(): string
    {
        return $this->documentHostName;
    }

    public function setDocumentHostName(string $documentHostName): self
    {
        $this->documentHostName = $documentHostName;

        return $this;
    }

    public function getDocumentPath(): string
    {
        return $this->documentPath;
    }

    public function setDocumentPath(string $documentPath): self
    {
        $this->documentPath = $documentPath;

        return $this;
    }

    public function getDocumentTitle(): string
    {
        return $this->documentTitle;
    }

    public function setDocumentTitle(string $documentTitle): self
    {
        $this->documentTitle = $documentTitle;

        return $this;
    }

    public function getProductAction(): string
    {
        return $this->productAction;
    }

    public function setProductAction(string $productAction): self
    {
        $this->productAction = $productAction;

        return $this;
    }

    public function getTransactionId(): string
    {
        return $this->transactionId;
    }

    public function setTransactionId(string $transactionId): self
    {
        $this->transactionId = $transactionId;

        return $this;
    }

    public function getTransactionAffiliation(): string
    {
        return $this->transactionAffiliation;
    }

    public function setTransactionAffiliation(string $transactionAffiliation): self
    {
        $this->transactionAffiliation = $transactionAffiliation;

        return $this;
    }

    public function getTransactionRevenue(): float
    {
        return $this->transactionRevenue;
    }

    public function setTransactionRevenue(float $transactionRevenue): self
    {
        $this->transactionRevenue = $transactionRevenue;

        return $this;
    }

    public function getTransactionShipping(): float
    {
        return $this->transactionShipping;
    }

    public function setTransactionShipping(float $transactionShipping): self
    {
        $this->transactionShipping = $transactionShipping;

        return $this;
    }

    public function getTransactionTax(): float
    {
        return $this->transactionTax;
    }

    public function setTransactionTax(float $transactionTax): self
    {
        $this->transactionTax = $transactionTax;

        return $this;
    }

    public function getTransactionCouponCode(): string
    {
        return $this->transactionCouponCode;
    }

    public function setTransactionCouponCode(string $transactionCouponCode): self
    {
        $this->transactionCouponCode = $transactionCouponCode;

        return $this;
    }

    public function getCheckoutStep(): int
    {
        return $this->checkoutStep;
    }

    public function setCheckoutStep(int $checkoutStep): self
    {
        $this->checkoutStep = $checkoutStep;

        return $this;
    }

    public function getCheckoutStepOption(): string
    {
        return $this->checkoutStepOption;
    }

    public function setCheckoutStepOption(string $checkoutStepOption): self
    {
        $this->checkoutStepOption = $checkoutStepOption;

        return $this;
    }

    public function getCurrencyCode(): string
    {
        return $this->currencyCode;
    }

    public function setCurrencyCode(string $currencyCode): self
    {
        $this->currencyCode = $currencyCode;

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
}
