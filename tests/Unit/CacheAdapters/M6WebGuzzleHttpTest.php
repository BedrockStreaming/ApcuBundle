<?php

namespace M6Web\ApcuBundle\Tests\Unit\CacheAdapters;

use M6Web\Bundle\ApcuBundle\CacheAdapters\M6WebGuzzleHttp;
use PHPUnit\Framework\TestCase;

class M6WebGuzzleHttpTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldCacheNormally(): void
    {
        $cacheInstance = $this->getCacheInstance();
        $key = 'foo';
        $value = 'bar';

        // Test a standard lifecycle of a cache variable
        $this->assertFalse($cacheInstance->has($key));

        $cacheInstance->set($key, 'bar');

        $this->assertTrue($cacheInstance->has($key));
        $this->assertEquals($value, $cacheInstance->get($key));

        $cacheInstance->remove($key);

        $this->assertFalse($cacheInstance->has($key));
        $this->assertNull($cacheInstance->get($key));

        // Test the setTtl
        $cacheInstance->set($key, $value, 1);
        $this->assertTrue($cacheInstance->has($key));

        sleep(2);

        $this->assertFalse($cacheInstance->has($key));
    }

    /**
     * @test
     */
    public function itShouldUseTheInstanceTTL(): void
    {
        $cacheInstance = $this->getCacheInstance();

        $this->assertNotEquals(1, $cacheInstance->getTtl());

        $cacheInstance->setTtl(1);

        $this->assertEquals(1, $cacheInstance->getTtl());

        $key = 'foo';
        $cacheInstance->set($key, 'bar');
        $this->assertTrue($cacheInstance->has($key));

        sleep(2);

        $this->assertFalse($cacheInstance->has($key));
    }

    /**
     * @test
     */
    public function itShouldChangeTheNamespace(): void
    {
        $cacheInstance = $this->getCacheInstance();

        $namespace = 'foo';

        $this->assertNotEquals($namespace, $cacheInstance->getNamespace());

        $cacheInstance->setNamespace($namespace);

        $this->assertEquals($namespace, $cacheInstance->getNamespace());
    }

    /**
     * @test
     */
    public function itShouldReturnAVariableTTL(): void
    {
        $cacheInstance = $this->getCacheInstance();
        $key = 'foo';
        $ttl = 2;

        $cacheInstance->set($key, 'bar', $ttl);

        $this->assertEquals($ttl, $cacheInstance->ttl($key));

        // Fetching an unexisting variable's TTL
        $this->assertNull($cacheInstance->get('bar'));
        $this->assertFalse($cacheInstance->ttl('bar'));
    }

    private function getCacheInstance(): M6WebGuzzleHttp
    {
        return new M6WebGuzzleHttp(uniqid());
    }
}
