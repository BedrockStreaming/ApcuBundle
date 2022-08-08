<?php

namespace M6Web\ApcuBundle\Tests\Unit\Guzzle;

use M6Web\Bundle\ApcuBundle\Apcu\Apcu;
use M6Web\Bundle\ApcuBundle\Guzzle\ApcuCacheAdapter;
use PHPUnit\Framework\TestCase;

class ApcuCacheAdapterTest extends TestCase
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
        $this->assertFalse($cacheInstance->contains($key));

        $cacheInstance->save($key, 'bar');

        $this->assertTrue($cacheInstance->contains($key));
        $this->assertEquals($value, $cacheInstance->fetch($key));

        $cacheInstance->delete($key);

        $this->assertFalse($cacheInstance->contains($key));
        $this->assertFalse($cacheInstance->fetch($key));

        // Test the setTtl
        $cacheInstance->save($key, $value, 1);
        $this->assertTrue($cacheInstance->contains($key));

        sleep(2);

        $this->assertFalse($cacheInstance->contains($key));
    }

    /**
     * @test
     */
    public function itShouldSetATTL(): void
    {
        $cacheInstance = $this->getCacheInstance(3);

        $this->assertEquals(3, $cacheInstance->getCacheObject()->getTtl());
    }

    private function getCacheInstance(?int $ttl=null): ApcuCacheAdapter
    {
        $apcuCache = new Apcu();

        return new ApcuCacheAdapter($apcuCache, $ttl);
    }
}
