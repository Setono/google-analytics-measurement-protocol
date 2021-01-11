<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Builder;

use Setono\GoogleAnalyticsMeasurementProtocol\Request\RequestInterface;
use Setono\GoogleAnalyticsMeasurementProtocol\Response\ResponseInterface;
use Setono\GoogleAnalyticsMeasurementProtocol\Storage\StorageInterface;

final class HitBuilder extends Builder implements PersistableBuilderInterface, RequestAwareBuilderInterface, ResponseAwareBuilderInterface
{
    private StorageInterface $storage;

    private string $storageKey;

    public string $protocolVersion;

    public string $propertyId;

    public bool $anonymizeIP;

    public string $dataSource;

    public string $clientId;

    public string $userId;

    public string $IPOverride;

    public string $userAgentOverride;

    public string $documentReferrer;

    public string $campaignName;

    public string $campaignSource;

    public string $campaignMedium;

    public string $campaignKeyword;

    public string $campaignContent;

    public string $campaignId;

    public string $googleAdsId;

    public string $googleDisplayAdsId;

    public string $hitType;

    public bool $nonInteractionHit;

    public string $documentLocationUrl;

    public string $documentHostName;

    public string $documentPath;

    public string $documentTitle;

    /**
     * Enhanced ecommerce properties
     */
    public string $productAction;

    public string $transactionId;

    public string $transactionAffiliation;

    public float $transactionRevenue;

    public float $transactionShipping;

    public float $transactionTax;

    public string $transactionCouponCode;

    public int $checkoutStep;

    public string $checkoutStepOption;

    public string $currencyCode;

    /** @var array<array-key, ProductBuilder> */
    public array $products = [];

    /** @psalm-suppress ConstructorSignatureMismatch */
    public function __construct(StorageInterface $storage, string $storageKey)
    {
        $this->storage = $storage;
        $this->storageKey = $storageKey;
    }

    public function getQuery(): string
    {
        $q = parent::getQuery();

        foreach ($this->products as $productBuilder) {
            $q .= '&' . $productBuilder->getQuery();
        }

        return $q;
    }

    public function populateFromRequest(RequestInterface $request): void
    {
        $this->documentLocationUrl = $request->getUrl();
        $this->userAgentOverride = $request->getUserAgent();
        $this->IPOverride = $request->getIp();

        $referrer = $request->getReferrer();
        if (null !== $referrer) {
            $this->documentReferrer = $referrer;
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

            $this->{$property} = $val;
        }
    }

    public function populateFromResponse(ResponseInterface $response): void
    {
        $title = $response->getTitle();
        if (null !== $title) {
            $this->documentTitle = $title;
        }
    }

    public function store(): void
    {
        $data = [];

        $reflection = new \ReflectionClass($this);
        foreach ($reflection->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            // only save properties that are actually set
            if (!isset($this->{$property->getName()})) {
                continue;
            }

            /** @psalm-suppress MixedAssignment */
            $data[$property->getName()] = $property->getValue($this);
        }

        $this->storage->store($this->storageKey, serialize($data));
    }

    public function restore(): void
    {
        $data = $this->storage->restore($this->storageKey);
        if (null === $data) {
            return;
        }

        /** @var array<string, mixed> $properties */
        $properties = unserialize($data, ['allowed_classes' => false]);

        /** @psalm-suppress MixedAssignment */
        foreach ($properties as $property => $value) {
            if (!property_exists($this, $property)) {
                continue;
            }

            $this->{$property} = $value;
        }
    }

    protected function getPropertyMapping(): array
    {
        return [
            'v' => 'protocolVersion',
            'tid' => 'propertyId',
            'aip' => 'anonymizeIP',
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
