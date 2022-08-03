<?php

declare(strict_types=1);

namespace M6Web\Bundle\ApcuBundle\Guzzle;

use Guzzle\Cache;
use M6Web\Bundle\ApcuBundle\Apcu\Apcu;

/**
 * Apcu cache adapter
 */
class ApcuCacheAdapter extends Cache\AbstractCacheAdapter
{
    /** @var Apcu */
    protected $cache;

    /**
     * ApcuCacheAdapter
     */
    public function __construct(Apcu $cache, ?int $ttl = null)
    {
        $this->cache = $cache;

        if (!is_null($ttl)) {
            $this->cache->setTtl($ttl);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function contains($id, ?array $options = null): bool
    {
        return $this->cache->exists($id);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id, ?array $options = null): bool
    {
        return $this->cache->delete($id);
    }

    /**
     * {@inheritdoc}
     */
    public function fetch($id, ?array $options = null)
    {
        return $this->cache->fetch($id);
    }

    /**
     * {@inheritdoc}
     */
    public function save($id, $data, $lifeTime = null, array $options = null): bool
    {
        return $this->cache->store($id, $data, $lifeTime);
    }
}
