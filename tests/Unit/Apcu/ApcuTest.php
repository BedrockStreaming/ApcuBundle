<?php

namespace M6Web\ApcuBundle\Tests\Unit\Apcu;

use M6Web\Bundle\ApcuBundle\Apcu\Apcu;
use PHPUnit\Framework\TestCase;

class ApcuTest extends TestCase
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
        $this->assertFalse($cacheInstance->exists($key));

        $cacheInstance->store($key, 'bar');

        $this->assertTrue($cacheInstance->exists($key));
        $this->assertEquals($value, $cacheInstance->fetch($key));

        $cacheInstance->delete($key);

        $this->assertFalse($cacheInstance->exists($key));
        $this->assertFalse($cacheInstance->fetch($key));

        // Test the TTL
        $cacheInstance->store($key, $value, 1);
        $this->assertTrue($cacheInstance->exists($key));

        sleep(2);

        $this->assertFalse($cacheInstance->exists($key));
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
        $cacheInstance->store($key, 'bar');
        $this->assertTrue($cacheInstance->exists($key));

        sleep(2);

        $this->assertFalse($cacheInstance->exists($key));
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

    private function getCacheInstance(): Apcu
    {
        return new Apcu(uniqid());
    }
}
