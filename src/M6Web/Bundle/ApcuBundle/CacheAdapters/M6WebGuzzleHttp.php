<?php

declare(strict_types=1);

namespace M6Web\Bundle\ApcuBundle\CacheAdapters;

use M6Web\Bundle\ApcuBundle\Apcu\Apcu as BaseApcu;
use M6Web\Bundle\GuzzleHttpBundle\Cache\CacheInterface;

/**
 * Cache interface for the m6web guzzlehttp bundle
 */
class M6WebGuzzleHttp extends BaseApcu implements CacheInterface
{
    /**
     * {@inheritDoc}
     */
    public function has($key): bool
    {
        return $this->exists($key);
    }

    /**
     * {@inheritDoc}
     */
    public function get($key): mixed
    {
        if (($value = $this->fetch($key)) === false) {
            return null;
        }

        return $value;
    }

    /**
     * {@inheritDoc}
     */
    public function set($key, $value, $ttl = null): bool
    {
        return $this->store($key, $value, $ttl);
    }

    /**
     * {@inheritDoc}
     */
    public function remove($key): bool|array
    {
        return $this->delete($key);
    }

    /**
     * {@inheritDoc}
     */
    public function ttl($key): int|false
    {
        $key = $this->getFinalKey($key);
        $infos = apcu_cache_info();

        foreach ($infos['cache_list'] as $entry) {
            if ($entry['info'] == $key) {
                return $entry['ttl'];
            }
        }

        return false;
    }
}
