# Google Analytics measurement protocol library

[![Latest Version][ico-version]][link-packagist]
[![Latest Unstable Version][ico-unstable-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Build Status][ico-github-actions]][link-github-actions]
[![Code Coverage][ico-code-coverage]][link-code-coverage]

## Installation

```bash
$ composer require setono/google-analytics-measurement-protocol
```

## Usage

See the [tests directory](tests/Builder).

[ico-version]: https://poser.pugx.org/setono/google-analytics-measurement-protocol/v/stable
[ico-unstable-version]: https://poser.pugx.org/setono/google-analytics-measurement-protocol/v/unstable
[ico-license]: https://poser.pugx.org/setono/google-analytics-measurement-protocol/license
[ico-github-actions]: https://github.com/Setono/google-analytics-measurement-protocol/workflows/build/badge.svg
[ico-code-coverage]: https://codecov.io/gh/Setono/google-analytics-measurement-protocol/branch/master/graph/badge.svg

[link-packagist]: https://packagist.org/packages/setono/google-analytics-measurement-protocol
[link-github-actions]: https://github.com/Setono/google-analytics-measurement-protocol/actions
[link-code-coverage]: https://codecov.io/gh/Setono/google-analytics-measurement-protocol

## Event class generation

The script `bin/gen.php` generates event classes based on https://developers.google.com/analytics/devguides/collection/protocol/ga4/reference/events.

It uses https://github.com/FriendsOfPHP/Goutte for data scraping and https://github.com/nette/php-generator for code generation.
