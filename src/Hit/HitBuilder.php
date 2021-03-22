<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Hit;

use Setono\GoogleAnalyticsMeasurementProtocol\DTO\Product;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\RequestInterface;
use Setono\GoogleAnalyticsMeasurementProtocol\Response\ResponseInterface;
use Setono\GoogleAnalyticsMeasurementProtocol\Storage\StorageInterface;
use Webmozart\Assert\Assert;

final class HitBuilder
{
    /** @var array<string, scalar> */
    private array $data = [];

    private int $productIndex = 0;

    private ?StorageInterface $storage = null;

    private ?string $storageKey = null;

    public function __construct()
    {
        $this->data['v'] = 1;
    }

    public function getHit(string $propertyId): Hit
    {
        $clientId = $this->getClientId();
        Assert::notNull($clientId, 'The client id is mandatory when generating a hit');

        $data = $this->data;
        $data['tid'] = $propertyId;

        $str = '';

        foreach ($data as $key => $value) {
            // if you cast false to string it returns '' (empty string) and not '0'
            if (is_bool($value) && false === $value) {
                $value = '0';
            }

            $str .= $key . '=' . $value . '&';
        }

        $str = rtrim($str, '&');

        return new Hit($propertyId, $clientId, $str);
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

            $this->{'set' . $property}($val);
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

        $this->storage->store($this->storageKey, serialize($this->data));
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

        $data = unserialize($stored, ['allowed_classes' => false]);
        Assert::isArray($data);
        foreach ($data as $key => $val) {
            Assert::string($key);
            Assert::scalar($val);

            $this->data[$key] = $val;
        }
    }

    public function setStorage(StorageInterface $storage, string $storageKey): void
    {
        $this->storage = $storage;
        $this->storageKey = $storageKey;
    }

    public function addProduct(Product $product): self
    {
        ++$this->productIndex;

        $this->data = array_merge($this->data, $product->generateData('pr' . $this->productIndex));

        return $this;
    }

    public function isAnonymizeIp(): ?bool
    {
        return $this->data['aip'] ?? null;
    }

    public function setAnonymizeIp(bool $anonymizeIp): self
    {
        $this->data['aip'] = $anonymizeIp;

        return $this;
    }

    public function getDataSource(): ?string
    {
        return $this->data['ds'] ?? null;
    }

    public function setDataSource(string $dataSource): self
    {
        $this->data['ds'] = $dataSource;

        return $this;
    }

    public function getClientId(): ?string
    {
        return $this->data['cid'] ?? null;
    }

    public function setClientId(string $clientId): self
    {
        $this->data['cid'] = $clientId;

        return $this;
    }

    public function getUserId(): ?string
    {
        return $this->data['uid'] ?? null;
    }

    public function setUserId(string $userId): self
    {
        $this->data['uid'] = $userId;

        return $this;
    }

    public function getIpOverride(): ?string
    {
        return $this->data['uip'] ?? null;
    }

    public function setIpOverride(string $ipOverride): self
    {
        $this->data['uip'] = $ipOverride;

        return $this;
    }

    public function getUserAgentOverride(): ?string
    {
        return $this->data['ua'] ?? null;
    }

    public function setUserAgentOverride(string $userAgentOverride): self
    {
        $this->data['ua'] = $userAgentOverride;

        return $this;
    }

    public function getDocumentReferrer(): ?string
    {
        return $this->data['dr'] ?? null;
    }

    public function setDocumentReferrer(string $documentReferrer): self
    {
        $this->data['dr'] = $documentReferrer;

        return $this;
    }

    public function getCampaignName(): ?string
    {
        return $this->data['cn'] ?? null;
    }

    public function setCampaignName(string $campaignName): self
    {
        $this->data['cn'] = $campaignName;

        return $this;
    }

    public function getCampaignSource(): ?string
    {
        return $this->data['cs'] ?? null;
    }

    public function setCampaignSource(string $campaignSource): self
    {
        $this->data['cs'] = $campaignSource;

        return $this;
    }

    public function getCampaignMedium(): ?string
    {
        return $this->data['cm'] ?? null;
    }

    public function setCampaignMedium(string $campaignMedium): self
    {
        $this->data['cm'] = $campaignMedium;

        return $this;
    }

    public function getCampaignKeyword(): ?string
    {
        return $this->data['ck'] ?? null;
    }

    public function setCampaignKeyword(string $campaignKeyword): self
    {
        $this->data['ck'] = $campaignKeyword;

        return $this;
    }

    public function getCampaignContent(): ?string
    {
        return $this->data['cc'] ?? null;
    }

    public function setCampaignContent(string $campaignContent): self
    {
        $this->data['cc'] = $campaignContent;

        return $this;
    }

    public function getCampaignId(): ?string
    {
        return $this->data['ci'] ?? null;
    }

    public function setCampaignId(string $campaignId): self
    {
        $this->data['ci'] = $campaignId;

        return $this;
    }

    public function getGoogleAdsId(): ?string
    {
        return $this->data['gclid'] ?? null;
    }

    public function setGoogleAdsId(string $googleAdsId): self
    {
        $this->data['gclid'] = $googleAdsId;

        return $this;
    }

    public function getGoogleDisplayAdsId(): ?string
    {
        return $this->data['dclid'] ?? null;
    }

    public function setGoogleDisplayAdsId(string $googleDisplayAdsId): self
    {
        $this->data['dclid'] = $googleDisplayAdsId;

        return $this;
    }

    public function getHitType(): ?string
    {
        return $this->data['t'] ?? null;
    }

    public function setHitType(string $hitType): self
    {
        $this->data['t'] = $hitType;

        return $this;
    }

    public function isNonInteractionHit(): ?bool
    {
        return $this->data['ni'] ?? null;
    }

    public function setNonInteractionHit(bool $nonInteractionHit): self
    {
        $this->data['ni'] = $nonInteractionHit;

        return $this;
    }

    public function getDocumentLocationUrl(): ?string
    {
        return $this->data['dl'] ?? null;
    }

    public function setDocumentLocationUrl(string $documentLocationUrl): self
    {
        $this->data['dl'] = $documentLocationUrl;

        return $this;
    }

    public function getDocumentHostName(): ?string
    {
        return $this->data['dh'] ?? null;
    }

    public function setDocumentHostName(string $documentHostName): self
    {
        $this->data['dh'] = $documentHostName;

        return $this;
    }

    public function getDocumentPath(): ?string
    {
        return $this->data['dp'] ?? null;
    }

    public function setDocumentPath(string $documentPath): self
    {
        $this->data['dp'] = $documentPath;

        return $this;
    }

    public function getDocumentTitle(): ?string
    {
        return $this->data['dt'] ?? null;
    }

    public function setDocumentTitle(string $documentTitle): self
    {
        $this->data['dt'] = $documentTitle;

        return $this;
    }

    public function getProductAction(): ?string
    {
        return $this->data['pa'] ?? null;
    }

    public function setProductAction(string $productAction): self
    {
        $this->data['pa'] = $productAction;

        return $this;
    }

    public function getTransactionId(): ?string
    {
        return $this->data['ti'] ?? null;
    }

    public function setTransactionId(string $transactionId): self
    {
        $this->data['ti'] = $transactionId;

        return $this;
    }

    public function getTransactionAffiliation(): ?string
    {
        return $this->data['ta'] ?? null;
    }

    public function setTransactionAffiliation(string $transactionAffiliation): self
    {
        $this->data['ta'] = $transactionAffiliation;

        return $this;
    }

    public function getTransactionRevenue(): ?float
    {
        return $this->data['tr'] ?? null;
    }

    public function setTransactionRevenue(float $transactionRevenue): self
    {
        $this->data['tr'] = $transactionRevenue;

        return $this;
    }

    public function getTransactionShipping(): ?float
    {
        return $this->data['ts'] ?? null;
    }

    public function setTransactionShipping(float $transactionShipping): self
    {
        $this->data['ts'] = $transactionShipping;

        return $this;
    }

    public function getTransactionTax(): ?float
    {
        return $this->data['tt'] ?? null;
    }

    public function setTransactionTax(float $transactionTax): self
    {
        $this->data['tt'] = $transactionTax;

        return $this;
    }

    public function getTransactionCouponCode(): ?string
    {
        return $this->data['tcc'] ?? null;
    }

    public function setTransactionCouponCode(string $transactionCouponCode): self
    {
        $this->data['tcc'] = $transactionCouponCode;

        return $this;
    }

    public function getCheckoutStep(): ?int
    {
        return $this->data['cos'] ?? null;
    }

    public function setCheckoutStep(int $checkoutStep): self
    {
        $this->data['cos'] = $checkoutStep;

        return $this;
    }

    public function getCheckoutStepOption(): ?string
    {
        return $this->data['col'] ?? null;
    }

    public function setCheckoutStepOption(string $checkoutStepOption): self
    {
        $this->data['col'] = $checkoutStepOption;

        return $this;
    }

    public function getCurrencyCode(): ?string
    {
        return $this->data['cu'] ?? null;
    }

    public function setCurrencyCode(string $currencyCode): self
    {
        $this->data['cu'] = $currencyCode;

        return $this;
    }
}
