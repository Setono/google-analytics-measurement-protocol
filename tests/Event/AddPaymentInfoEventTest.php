<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Event;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Psr7\Utils as Psr7Utils;
use GuzzleHttp\Utils;
use PHPUnit\Framework\TestCase;

final class AddPaymentInfoEventTest extends TestCase
{
    /**
     * @test
     * @dataProvider exampleEventProvider
     */
    public function it_returns_array(EventInterface $event): void
    {
        self::assertSame([
            'name' => 'add_payment_info',
            'params' => [
                'coupon' => 'SUMMER_FUN',
                'currency' => 'USD',
                'payment_type' => 'Credit Card',
                'value' => 7.77,
                'items' => [['item_id' => 'SKU_12345']],
            ],
        ], $event->toArray());
    }

    /**
     * @test
     * @dataProvider exampleEventProvider
     */
    public function it_yields_a_valid_request(EventInterface $event): void
    {
        $aggregate = new Aggregate('XXXXXXXXXX.YYYYYYYYYY', $event);

        $uri = Uri::withQueryValues(
            new Uri('https://www.google-analytics.com/debug/mp/collect'),
            ['api_secret' => '<secret_value>', 'measurement_id' => 'G-XXXXXXXXXX']
        );

        $request = (new Request('POST', $uri))
            ->withBody(Psr7Utils::streamFor(Utils::jsonEncode($aggregate->toArray())))
        ;

        $client = new Client();
        $response = $client->sendRequest($request);
        $statusCode = $response->getStatusCode();
        $contents = $response->getBody()->getContents();
        $data = Utils::jsonDecode($contents, true);

        self::assertEquals(200, $statusCode);
        self::assertEquals(['validationMessages' => []], $data, sprintf("Unexpected validation issues:\n %s", $contents));
    }

    public function exampleEventProvider(): iterable
    {
        $event = new AddPaymentInfoEvent();
        $event->parameters->coupon = 'SUMMER_FUN';
        $event->parameters->currency = 'USD';
        $event->parameters->paymentType = 'Credit Card';
        $event->parameters->value = 7.77;

        $item = new GenericItemEventParameters();
        $item->itemId = 'SKU_12345';

        $event->parameters->addItem($item);

        return [[$event]];
    }
}
