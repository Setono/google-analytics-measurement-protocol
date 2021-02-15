<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Storage\Adapter;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\SessionBagInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * @covers \Setono\GoogleAnalyticsMeasurementProtocol\Storage\Adapter\SymfonySessionStorageAdapter
 */
class SymfonySessionStorageAdapterTest extends TestCase
{
    /**
     * @test
     */
    public function it_stores(): void
    {
        $storage = new SymfonySessionStorageAdapter(self::getSession());

        $storage->store('key1', 'value1');
        $storage->store('key2', 'value2');

        self::assertSame('value1', $storage->restore('key1'));
        self::assertSame('value2', $storage->restore('key2'));
    }

    private static function getSession(): SessionInterface
    {
        return new class() implements SessionInterface {
            private array $data = [];

            public function start()
            {
                // TODO: Implement start() method.
            }

            public function getId()
            {
                // TODO: Implement getId() method.
            }

            public function setId(string $id)
            {
                // TODO: Implement setId() method.
            }

            public function getName()
            {
                // TODO: Implement getName() method.
            }

            public function setName(string $name)
            {
                // TODO: Implement setName() method.
            }

            public function invalidate(int $lifetime = null)
            {
                // TODO: Implement invalidate() method.
            }

            public function migrate(bool $destroy = false, int $lifetime = null)
            {
                // TODO: Implement migrate() method.
            }

            public function save()
            {
                // TODO: Implement save() method.
            }

            public function has(string $name)
            {
                // TODO: Implement has() method.
            }

            public function get(string $name, $default = null)
            {
                return $this->data[$name] ?? $default;
            }

            public function set(string $name, $value)
            {
                $this->data[$name] = $value;
            }

            public function all()
            {
                // TODO: Implement all() method.
            }

            public function replace(array $attributes)
            {
                // TODO: Implement replace() method.
            }

            public function remove(string $name)
            {
                // TODO: Implement remove() method.
            }

            public function clear()
            {
                // TODO: Implement clear() method.
            }

            public function isStarted()
            {
                // TODO: Implement isStarted() method.
            }

            public function registerBag(SessionBagInterface $bag)
            {
                // TODO: Implement registerBag() method.
            }

            public function getBag(string $name)
            {
                // TODO: Implement getBag() method.
            }

            public function getMetadataBag()
            {
                // TODO: Implement getMetadataBag() method.
            }
        };
    }
}
