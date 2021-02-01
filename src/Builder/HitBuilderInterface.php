<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Builder;

use Setono\GoogleAnalyticsMeasurementProtocol\Hit\Hit;

interface HitBuilderInterface extends QueryBuilderInterface
{
    public function getHit(): Hit;

    public function getProtocolVersion(): string;

    public function setProtocolVersion(string $protocolVersion): self;

    public function getPropertyId(): string;

    public function setPropertyId(string $propertyId): self;

    public function isAnonymizeIP(): bool;

    public function setAnonymizeIP(bool $anonymizeIP): self;

    public function getDataSource(): string;

    public function setDataSource(string $dataSource): self;

    public function getClientId(): string;

    public function setClientId(string $clientId): self;

    public function getUserId(): string;

    public function setUserId(string $userId): self;

    public function getIPOverride(): string;

    public function setIPOverride(string $IPOverride): self;

    public function getUserAgentOverride(): string;

    public function setUserAgentOverride(string $userAgentOverride): self;

    public function getDocumentReferrer(): string;

    public function setDocumentReferrer(string $documentReferrer): self;

    public function getCampaignName(): string;

    public function setCampaignName(string $campaignName): self;

    public function getCampaignSource(): string;

    public function setCampaignSource(string $campaignSource): self;

    public function getCampaignMedium(): string;

    public function setCampaignMedium(string $campaignMedium): self;

    public function getCampaignKeyword(): string;

    public function setCampaignKeyword(string $campaignKeyword): self;

    public function getCampaignContent(): string;

    public function setCampaignContent(string $campaignContent): self;

    public function getCampaignId(): string;

    public function setCampaignId(string $campaignId): self;

    public function getGoogleAdsId(): string;

    public function setGoogleAdsId(string $googleAdsId): self;

    public function getGoogleDisplayAdsId(): string;

    public function setGoogleDisplayAdsId(string $googleDisplayAdsId): self;

    public function getHitType(): string;

    public function setHitType(string $hitType): self;

    public function isNonInteractionHit(): bool;

    public function setNonInteractionHit(bool $nonInteractionHit): self;

    public function getDocumentLocationUrl(): string;

    public function setDocumentLocationUrl(string $documentLocationUrl): self;

    public function getDocumentHostName(): string;

    public function setDocumentHostName(string $documentHostName): self;

    public function getDocumentPath(): string;

    public function setDocumentPath(string $documentPath): self;

    public function getDocumentTitle(): string;

    public function setDocumentTitle(string $documentTitle): self;

    public function getProductAction(): string;

    public function setProductAction(string $productAction): self;

    public function getTransactionId(): string;

    public function setTransactionId(string $transactionId): self;

    public function getTransactionAffiliation(): string;

    public function setTransactionAffiliation(string $transactionAffiliation): self;

    public function getTransactionRevenue(): float;

    public function setTransactionRevenue(float $transactionRevenue): self;

    public function getTransactionShipping(): float;

    public function setTransactionShipping(float $transactionShipping): self;

    public function getTransactionTax(): float;

    public function setTransactionTax(float $transactionTax): self;

    public function getTransactionCouponCode(): string;

    public function setTransactionCouponCode(string $transactionCouponCode): self;

    public function getCheckoutStep(): int;

    public function setCheckoutStep(int $checkoutStep): self;

    public function getCheckoutStepOption(): string;

    public function setCheckoutStepOption(string $checkoutStepOption): self;

    public function getCurrencyCode(): string;

    public function setCurrencyCode(string $currencyCode): self;

    /**
     * @return ProductBuilder[]
     */
    public function getProducts(): array;

    /**
     * @param ProductBuilder[] $products
     */
    public function setProducts(array $products): self;

    public function addProduct(ProductBuilder $product): self;
}
