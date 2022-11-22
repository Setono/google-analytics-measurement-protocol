# Google Analytics measurement protocol library

[![Latest Version][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Build Status][ico-github-actions]][link-github-actions]
[![Code Coverage][ico-code-coverage]][link-code-coverage]
[![Mutation testing][ico-infection]][link-infection]

Easily build payloads for the [Google Analytics measurement protocol](https://developers.google.com/analytics/devguides/collection/protocol/ga4).

Version ^1.0 of this library supports the GA4 measurement protocol while < 1.0 supports the Universal Analytics measurement protocol.

## Installation

```bash
composer require setono/google-analytics-measurement-protocol
```

## Usage

```php
<?php

require_once '../vendor/autoload.php';

use Setono\GoogleAnalyticsMeasurementProtocol\Client\Client;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Body;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\AddToCartEvent;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Item\Item;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Request;

$client = new Client();
$request = Request::create(
    'YOUR_SECRET',
    'G-12341234',
    Body::create('CLIENT_ID')
        ->addEvent(
            AddToCartEvent::create()
                ->setCurrency('USD')
                ->setValue(123.45)
                ->addItem(Item::create()->setId('SKU1234')->setName('Blue t-shirt')),
        )->setTimestamp(1668509674013800),
);

$client->sendRequest($request);
```

## References

- https://developers.google.com/analytics/devguides/collection/protocol/ga4
- https://developers.google.com/analytics/devguides/collection/protocol/ga4/reference/events
- https://support.google.com/analytics/answer/9234069
- https://support.google.com/analytics/answer/9216061

[ico-version]: https://poser.pugx.org/setono/google-analytics-measurement-protocol/v/stable
[ico-license]: https://poser.pugx.org/setono/google-analytics-measurement-protocol/license
[ico-github-actions]: https://github.com/Setono/google-analytics-measurement-protocol/workflows/build/badge.svg
[ico-code-coverage]: https://codecov.io/gh/Setono/google-analytics-measurement-protocol/branch/master/graph/badge.svg
[ico-infection]: https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2FSetono%2Fgoogle-analytics-measurement-protocol%2Fmaster

[link-packagist]: https://packagist.org/packages/setono/google-analytics-measurement-protocol
[link-github-actions]: https://github.com/Setono/google-analytics-measurement-protocol/actions
[link-code-coverage]: https://codecov.io/gh/Setono/google-analytics-measurement-protocol
[link-infection]: https://dashboard.stryker-mutator.io/reports/github.com/Setono/google-analytics-measurement-protocol/master
