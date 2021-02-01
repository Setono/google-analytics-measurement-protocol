<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Builder;

use Setono\GoogleAnalyticsMeasurementProtocol\Hit\Hit;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\RequestInterface;
use Setono\GoogleAnalyticsMeasurementProtocol\Response\ResponseInterface;
use Setono\GoogleAnalyticsMeasurementProtocol\Storage\StorageInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

final class HitBuilder extends QueryBuilder implements HitBuilderInterface, PersistableQueryBuilderInterface, RequestAwareQueryBuilderInterface, ResponseAwareQueryBuilderInterface
{
    use HitBuilderTrait;

    private StorageInterface $storage;

    private string $storageKey;

    private PropertyAccessorInterface $propertyAccessor;

    /** @psalm-suppress ConstructorSignatureMismatch */
    public function __construct(StorageInterface $storage, string $storageKey, PropertyAccessorInterface $propertyAccessor = null)
    {
        $this->storage = $storage;
        $this->storageKey = $storageKey;
        $this->propertyAccessor = $propertyAccessor ?? PropertyAccess::createPropertyAccessor();
    }

    public function getHit(): Hit
    {
        return new Hit($this->getQuery(), $this->clientId);
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
        foreach ($reflection->getProperties() as $property) {
            $propertyName = $property->getName();

            if (!$this->propertyAccessor->isReadable($this, $propertyName)) {
                continue;
            }

            /** @psalm-suppress MixedAssignment */
            $data[$propertyName] = $this->propertyAccessor->getValue($this, $propertyName);
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
            if (!$this->propertyAccessor->isWritable($this, $property)) {
                continue;
            }

            $this->propertyAccessor->setValue($this, $property, $value);
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
