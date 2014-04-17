<?php
namespace M6Web\Bundle\ApcuBundle\Tests\Units\M6WebWSClient;

require __DIR__.'/../../../../../../../vendor/autoload.php';

use mageekguy\atoum;
use M6Web\Bundle\ApcuBundle\M6WebWSClient\Apcu as Base;

/**
 * Apcu with WSClient interface test
 */
class Apcu extends atoum\test
{
    /**
     * Create cace instance
     *
     * @return Base
     */
    public function getCacheInstance()
    {
        return new Base(uniqid());
    }

    /**
     * Test standard cache process
     */
    public function testStandardChacheProcess()
    {
        $cache = $this->getCacheInstance();
        $key   = 'foo-bar';

        $this
            ->boolean($cache->has($key))
                ->isFalse()
            ->boolean($cache->set($key, 'foo', 10))
                ->isTrue()
            ->boolean($cache->has($key))
                ->isTrue()
            ->string($cache->get($key))
                ->isEqualTo('foo')
            ->boolean($cache->remove($key))
                ->isTrue()
            ->boolean($cache->has($key))
                ->isFalse()
            ->boolean($cache->get($key))
                ->isFalse()
        ;
    }

    /**
     * Test TTL functions
     */
    public function testTtl()
    {
        $cache = $this->getCacheInstance();

        $cache->store('bar', 'foo', 120);

        $this
            ->integer($cache->ttl('bar'))
                ->isIdenticalTo(120)
        ;

        $cache->setTtl(360);
        $cache->store('barbar', 'foo');

        $this
            ->integer($cache->ttl('barbar'))
                ->isIdenticalTo(360)
        ;
    }
}