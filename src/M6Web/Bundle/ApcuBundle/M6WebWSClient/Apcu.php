<?php

namespace M6Web\Bundle\ApcuBundle\M6WebWSClient;

use M6Web\Bundle\WSClientBundle\Cache\CacheInterface;
use M6Web\Bundle\ApcuBundle\Apcu\Apcu as BaseApcu;

/**
 * Class Apcu adapted to an usage throught the WsClient
 *
 * @package M6Web\Bundle\ApcuBundle\M6WebWSClient
 */
class Apcu extends BaseApcu implements CacheInterface
{
    /**
     * {@inheritDoc}
     */
    public function has($key)
    {
        return $this->exists($key);
    }

    /**
     * {@inheritDoc}
     */
    public function get($key)
    {
        return $this->fetch($key);
    }

    /**
     * {@inheritDoc}
     */
    public function set($key, $value, $ttl = null)
    {
        return $this->store($key, $value, $ttl);
    }

    /**
     * {@inheritDoc}
     */
    public function remove($key)
    {
        return $this->delete($key);
    }

    /**
     * {@inheritDoc}
     */
    public function ttl($key)
    {
        $key   = $this->getFinalKey($key);
        $infos = apcu_cache_info();

        foreach ($infos['cache_list'] as $entry) {
            if ($entry['key'] == $key) {
                return $entry['ttl'];
            }
        }

        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function shouldResetCache()
    {
        return false;
    }
}
