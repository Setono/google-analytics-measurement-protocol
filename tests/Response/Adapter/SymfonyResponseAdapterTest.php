<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Response\Adapter;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * @covers \Setono\GoogleAnalyticsMeasurementProtocol\Response\Adapter\SymfonyResponseAdapter
 */
final class SymfonyResponseAdapterTest extends TestCase
{
    /**
     * @test
     */
    public function it_returns_title(): void
    {
        $response = new Response(
            <<<CONTENT
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

    /**
     * @test
     */
    public function it_returns_multiline_title(): void
    {
        $response = new Response(
            <<<CONTENT
<!doctype html>
<html lang="en">
    <head>
      <meta charset="utf-8">
      <title>
      Great website!

      </title>
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

    /**
     * @test
     */
    public function it_returns_cased_title(): void
    {
        $response = new Response(
            <<<CONTENT
<!doctype html>
<html lang="en">
    <head>
      <meta charset="utf-8">
      <TITLE>Great website!</TITLE>
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

    /**
     * @test
     */
    public function it_returns_encoded_title(): void
    {
        $response = new Response(
            <<<CONTENT
<!doctype html>
<html lang="en">
    <head>
      <meta charset="utf-8">
      <title>Great website &amp; what not!</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
      <p>Hello world! This is HTML5 Boilerplate.</p>
    </body>
</html>
CONTENT
        );
        $adapter = new SymfonyResponseAdapter($response);

        self::assertSame('Great website & what not!', $adapter->getTitle());
    }

    /**
     * @test
     */
    public function it_checks_for_false(): void
    {
        $response = new class() extends Response {
            public function getContent()
            {
                return false;
            }
        };
        $adapter = new SymfonyResponseAdapter($response);

        self::assertNull($adapter->getTitle());
    }

    /**
     * @test
     */
    public function it_checks_for_no_title(): void
    {
        $response = new Response(
            <<<CONTENT
<!doctype html>
<html lang="en">
    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
      <p>Hello world! This is HTML5 Boilerplate.</p>
    </body>
</html>
CONTENT
        );
        $adapter = new SymfonyResponseAdapter($response);

        self::assertNull($adapter->getTitle());
    }

    /**
     * @test
     */
    public function it_checks_for_empty_title(): void
    {
        $response = new Response(
            <<<CONTENT
<!doctype html>
<html lang="en">
    <head>
      <meta charset="utf-8">
      <title></title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
      <p>Hello world! This is HTML5 Boilerplate.</p>
    </body>
</html>
CONTENT
        );
        $adapter = new SymfonyResponseAdapter($response);

        self::assertNull($adapter->getTitle());
    }
}
