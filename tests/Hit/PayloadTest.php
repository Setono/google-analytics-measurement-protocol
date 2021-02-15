<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Hit;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Setono\GoogleAnalyticsMeasurementProtocol\Hit\Payload
 */
class PayloadTest extends TestCase
{
    /**
     * @test
     */
    public function it_returns_payload_value(): void
    {
        $obj = new Payload();
        $obj->set('key1', 'value1');
        $obj->set('key2', 'value2');

        $expected = 'key1=value1&key2=value2';

        self::assertSame($expected, $obj->getValue());
        self::assertSame($expected, (string) $obj);
    }

    /**
     * @test
     */
    public function it_merges_payload(): void
    {
        $obj1 = new Payload();
        $obj1->set('key1', 'value1');
        $obj1->set('key2', 'value2');

        $obj2 = new Payload();
        $obj2->set('key1', 'new_value1');
        $obj2->set('key3', 'value3');

        $obj1->mergePayload($obj2);

        self::assertSame('key1=new_value1&key2=value2&key3=value3', $obj1->getValue());
    }

    /**
     * @test
     */
    public function it_returns_payload_value_if_a_value_is_boolean(): void
    {
        $obj = new Payload();
        $obj->set('key1', 'value1');
        $obj->set('key2', false);
        $obj->set('key3', true);

        self::assertSame('key1=value1&key2=0&key3=1', $obj->getValue());
    }

    /**
     * @test
     */
    public function it_returns_value_from_key(): void
    {
        $obj = new Payload();
        $obj->set('key', 'value');

        self::assertSame('value', $obj->get('key'));
    }

    /**
     * @test
     */
    public function it_returns_null_if_key_does_not_exist(): void
    {
        $obj = new Payload();

        self::assertNull($obj->get('key'));
    }

    /**
     * @test
     */
    public function it_returns_keys(): void
    {
        $obj = new Payload();
        $obj->set('key1', 'value');
        $obj->set('key2', 'value');

        self::assertEquals(['key1', 'key2'], $obj->keys());
    }

    /**
     * @test
     */
    public function it_throws_exception_if_input_is_not_scalar(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $obj = new Payload();
        $obj->set('key1', []);
    }
}
