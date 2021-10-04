<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Hit;

use Setono\GoogleAnalyticsMeasurementProtocol\Request\RequestInterface;
use Setono\GoogleAnalyticsMeasurementProtocol\Response\ResponseInterface;

interface HitBuilderInterface
{
    public const PARAMETER_CLIENT_ID = 'cid';

    public const PARAMETER_PROPERTY_ID = 'tid';

    public const PARAMETER_QUEUE_TIME = 'qt';

    public const HIT_TYPE_PAGEVIEW = 'pageview';

    public const HIT_TYPE_SCREENVIEW = 'screenview';

    public const HIT_TYPE_EVENT = 'event';

    public const HIT_TYPE_TRANSACTION = 'transaction';

    public const HIT_TYPE_ITEM = 'item';

    public const HIT_TYPE_SOCIAL = 'social';

    public const HIT_TYPE_EXCEPTION = 'exception';

    public const HIT_TYPE_TIMING = 'timing';

    /**
     * @return array<string, scalar>
     */
    public function getData(): array;

    public function getHit(string $propertyId): Hit;

    /**
     * @throws \InvalidArgumentException if any required properties are not set or are invalid
     */
    public function validate(): void;

    public function populateFromRequest(RequestInterface $request): void;

    public function populateFromResponse(ResponseInterface $response): void;

    public function isAnonymizeIp(): ?bool;

    public function setAnonymizeIp(bool $anonymizeIp): self;

    public function getDataSource(): ?string;

    public function setDataSource(string $dataSource): self;

    public function getClientId(): ?string;

    public function setClientId(string $clientId): self;

    public function getUserId(): ?string;

    public function setUserId(string $userId): self;

    public function getIpOverride(): ?string;

    public function setIpOverride(string $ipOverride): self;

    public function getUserAgentOverride(): ?string;

    public function setUserAgentOverride(string $userAgentOverride): self;

    public function getDocumentReferrer(): ?string;

    public function setDocumentReferrer(string $documentReferrer): self;

    public function getCampaignName(): ?string;

    public function setCampaignName(string $campaignName): self;

    public function getCampaignSource(): ?string;

    public function setCampaignSource(string $campaignSource): self;

    public function getCampaignMedium(): ?string;

    public function setCampaignMedium(string $campaignMedium): self;

    public function getCampaignKeyword(): ?string;

    public function setCampaignKeyword(string $campaignKeyword): self;

    public function getCampaignContent(): ?string;

    public function setCampaignContent(string $campaignContent): self;

    public function getCampaignId(): ?string;

    public function setCampaignId(string $campaignId): self;

    public function getGoogleAdsId(): ?string;

    public function setGoogleAdsId(string $googleAdsId): self;

    public function getGoogleDisplayAdsId(): ?string;

    public function setGoogleDisplayAdsId(string $googleDisplayAdsId): self;

    public function getScreenResolution(): ?string;

    public function setScreenResolution(string $screenResolution): self;

    public function getViewportSize(): ?string;

    public function setViewportSize(string $viewportSize): self;

    public function getScreenColors(): ?string;

    public function setScreenColors(string $screenColors): self;

    public function getUserLanguage(): ?string;

    public function setUserLanguage(string $userLanguage): self;

    public function getHitType(): string;

    public function setHitType(string $hitType): self;

    public function isNonInteractionHit(): ?bool;

    public function setNonInteractionHit(bool $nonInteractionHit): self;

    public function getDocumentLocationUrl(): ?string;

    public function setDocumentLocationUrl(string $documentLocationUrl): self;

    public function getDocumentHostName(): ?string;

    public function setDocumentHostName(string $documentHostName): self;

    public function getDocumentPath(): ?string;

    public function setDocumentPath(string $documentPath): self;

    public function getDocumentTitle(): ?string;

    public function setDocumentTitle(string $documentTitle): self;

    public function getEventCategory(): ?string;

    public function setEventCategory(string $eventCategory): self;

    public function getEventAction(): ?string;

    public function setEventAction(string $eventAction): self;

    public function getEventLabel(): ?string;

    public function setEventLabel(string $eventLabel): self;

    public function getEventValue(): ?int;

    public function setEventValue(int $eventValue): self;

    public function getProductAction(): ?string;

    /**
     * See https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#pa
     */
    public function setProductAction(string $productAction): self;

    public function getTransactionId(): ?string;

    public function setTransactionId(string $transactionId): self;

    public function getTransactionAffiliation(): ?string;

    public function setTransactionAffiliation(string $transactionAffiliation): self;

    public function getTransactionRevenue(): ?float;

    public function setTransactionRevenue(float $transactionRevenue): self;

    public function getTransactionShipping(): ?float;

    public function setTransactionShipping(float $transactionShipping): self;

    public function getTransactionTax(): ?float;

    public function setTransactionTax(float $transactionTax): self;

    public function getTransactionCouponCode(): ?string;

    public function setTransactionCouponCode(string $transactionCouponCode): self;

    public function getCheckoutStep(): ?int;

    public function setCheckoutStep(int $checkoutStep): self;

    public function getCheckoutStepOption(): ?string;

    public function setCheckoutStepOption(string $checkoutStepOption): self;

    public function getCurrencyCode(): ?string;

    public function setCurrencyCode(string $currencyCode): self;

    /**
     * Product specific setters
     */
    public function setProductSku(?string $sku, int $index): self;

    public function setProductName(?string $name, int $index): self;

    public function setProductBrand(?string $brand, int $index): self;

    public function setProductCategory(?string $category, int $index): self;

    public function setProductVariant(?string $variant, int $index): self;

    public function setProductPrice(?float $price, int $index): self;

    public function setProductQuantity(?int $quantity, int $index): self;

    public function setProductCouponCode(?string $couponCode, int $index): self;

    public function setProductPosition(?int $position, int $index): self;

    public function setProductCustomDimension(?string $dimension, int $dimensionIndex, int $productIndex): self;

    /**
     * @param mixed $metric
     */
    public function setProductCustomMetric($metric, int $metricIndex, int $productIndex): self;

    /**
     * Product impression specific setters
     */
    public function setProductImpressionSku(?string $sku, int $index, int $impressionListIndex): self;

    public function setProductImpressionName(?string $name, int $index, int $impressionListIndex): self;

    public function setProductImpressionBrand(?string $brand, int $index, int $impressionListIndex): self;

    public function setProductImpressionCategory(?string $category, int $index, int $impressionListIndex): self;

    public function setProductImpressionVariant(?string $variant, int $index, int $impressionListIndex): self;

    public function setProductImpressionPrice(?float $price, int $index, int $impressionListIndex): self;

    public function setProductImpressionCouponCode(?string $couponCode, int $index, int $impressionListIndex): self;

    public function setProductImpressionPosition(?int $position, int $index, int $impressionListIndex): self;

    public function setProductImpressionCustomDimension(?string $dimension, int $dimensionIndex, int $productIndex, int $impressionListIndex): self;

    /**
     * @param mixed $metric
     */
    public function setProductImpressionCustomMetric($metric, int $metricIndex, int $productIndex, int $impressionListIndex): self;
}
