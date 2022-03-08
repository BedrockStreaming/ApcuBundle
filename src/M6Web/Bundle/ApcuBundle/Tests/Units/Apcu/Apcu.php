<?php

namespace M6Web\Bundle\ApcuBundle\Tests\Units\Apcu;

use M6Web\Bundle\ApcuBundle\Apcu\Apcu as Base;

/**
 * Apcu class test
 */
class Apcu extends \atoum
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
        $key = 'foo-bar';

        $this
            ->boolean($cache->exists($key))
                ->isFalse()
            ->boolean($cache->store($key, 'foo', 10))
                ->isTrue()
            ->boolean($cache->exists($key))
                ->isTrue()
            ->string($cache->fetch($key))
                ->isEqualTo('foo')
            ->boolean($cache->delete($key))
                ->isTrue()
            ->boolean($cache->exists($key))
                ->isFalse()
            ->boolean($cache->fetch($key))
                ->isFalse()
        ;
    }

    /**
     * Test getter/setter
     */
    public function testGetSet()
    {
        $cache = $this->getCacheInstance();

        $namespace = uniqid();
        $ttl = rand(1000, 10000);

        $cache
            ->setNamespace($namespace)
            ->setTtl($ttl);

        $this
            ->string($cache->getNamespace())
                ->isIdenticalTo($namespace)
            ->integer($cache->getTtl())
                ->isIdenticalTo($ttl)
        ;
    }
}
