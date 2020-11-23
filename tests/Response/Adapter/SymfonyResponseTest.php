<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Response\Adapter;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

final class SymfonyResponseTest extends TestCase
{
    /**
     * @test
     */
    public function it_returns_title(): void
    {
        $response = new Response(<<<CONTENT
<!doctype html>
<html lang="en">
    <head>
      <meta charset="utf-8">
      <title>Great website!</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
      <p>Hello world! This is HTML5 Boilerplate.</p>
    </body>
</html>
CONTENT
);
        $adapter = new SymfonyResponseAdapter($response);

        self::assertSame('Great website!', $adapter->getTitle());
    }
}
