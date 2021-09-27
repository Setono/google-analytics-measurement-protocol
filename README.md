# Google Analytics measurement protocol library

[![Latest Version][ico-version]][link-packagist]
[![Latest Unstable Version][ico-unstable-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Build Status][ico-github-actions]][link-github-actions]
[![Code Coverage][ico-code-coverage]][link-code-coverage]
[![Mutation testing][ico-infection]][link-infection]

Easily build payloads for the [Google Analytics measurement protocol](https://developers.google.com/analytics/devguides/collection/protocol/v1).

## Installation

```bash
$ composer require setono/google-analytics-measurement-protocol
```

## Usage

Build your `Hit` using the `HitBuilder`:

```php
<?php
use Setono\GoogleAnalyticsMeasurementProtocol\Hit\HitBuilder;
use Setono\GoogleAnalyticsMeasurementProtocol\Hit\HitBuilderInterface;

$hitBuilder = new HitBuilder(HitBuilderInterface::HIT_TYPE_PAGEVIEW);
$hitBuilder->setClientId('CLIENT_ID');
$hit = $hitBuilder->getHit('UA-1234-1');

echo $hit; // outputs v=1&t=pageview&cid=CLIENT_ID&tid=UA-1234-1
```

then use the `Client` to send the hit:

```php
<?php
use Setono\GoogleAnalyticsMeasurementProtocol\Client\Client;

$client = new Client();
$client->sendHit($hit);
```

[ico-version]: https://poser.pugx.org/setono/google-analytics-measurement-protocol/v/stable
[ico-unstable-version]: https://poser.pugx.org/setono/google-analytics-measurement-protocol/v/unstable
[ico-license]: https://poser.pugx.org/setono/google-analytics-measurement-protocol/license
[ico-github-actions]: https://github.com/Setono/google-analytics-measurement-protocol/workflows/build/badge.svg
[ico-code-coverage]: https://codecov.io/gh/Setono/google-analytics-measurement-protocol/branch/master/graph/badge.svg
[ico-infection]: https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2FSetono%2Fgoogle-analytics-measurement-protocol%2Fmaster

[link-packagist]: https://packagist.org/packages/setono/google-analytics-measurement-protocol
[link-github-actions]: https://github.com/Setono/google-analytics-measurement-protocol/actions
[link-code-coverage]: https://codecov.io/gh/Setono/google-analytics-measurement-protocol
[link-infection]: https://dashboard.stryker-mutator.io/reports/github.com/Setono/google-analytics-measurement-protocol/master
