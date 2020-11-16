<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Builder;

use function Safe\sprintf;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\RequestInterface;

final class HitBuilder extends Builder
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

    public EnhancedEcommerceBuilder $enhancedEcommerce;

    public function getQuery(): string
    {
        $mapping = [
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
            'enhancedEcommerce',
        ];

        $q = $this->buildQuery($mapping, function (?string $parameter, string $value): string {
            if (null === $parameter) {
                return $value . '&';
            }

            return sprintf('%s=%s&', $parameter, $value);
        });

        return rtrim($q, '&');
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
}
