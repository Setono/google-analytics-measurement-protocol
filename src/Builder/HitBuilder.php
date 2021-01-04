<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Builder;

use Setono\GoogleAnalyticsMeasurementProtocol\Request\RequestInterface;
use Setono\GoogleAnalyticsMeasurementProtocol\Response\ResponseInterface;

final class HitBuilder extends Builder implements RequestAwareBuilderInterface, ResponseAwareBuilderInterface
{
    public string $protocolVersion;

    public string $measurementId;

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

    /** @var ProductBuilder[] */
    public array $products = [];

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

    public function addProduct(ProductBuilder $productBuilder): void
    {
        $this->products[] = $productBuilder;
    }

    protected function getPropertyMapping(): array
    {
        return [
            'v' => 'protocolVersion',
            'tid' => 'measurementId',
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
