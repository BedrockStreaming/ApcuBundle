<?php

namespace M6Web\Bundle\ApcuBundle\Apcu;

/**
 * Provide APCu abstraction
 * with namespace feature
 */
class Apcu
{
    /** @var string */
    protected $namespace;

    /** @var ttl */
    protected $ttl;

    /**
     * Construct
     *
     * @param string $namespace Namespace
     * @param int    $ttl       Default TTL
     */
    public function __construct($namespace = '', $ttl = 3600)
    {
        $this->setNamespace($namespace);
    }

    /**
     * Define cache namespace
     *
     * @param string $namespace
     *
     * @return $this
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;

        return $this;
    }

    /**
     * Get cache namespace
     *
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Define default TTL
     *
     * @param int $ttl
     *
     * @return $this [description]
     */
    public function setTtl($ttl)
    {
        $this->ttl = $ttl;

        return $this;
    }

    /**
     * Get default TTL
     *
     * @return int
     */
    public function getTtl()
    {
        return $this->ttl;
    }

    /**
     * Store data in memory
     *
     * @param string $key Key
     * @param mixed  $var Data
     * @param int    $ttl TTL seconds
     *
     * @return bool
     */
    public function store($key, $var, $ttl = null)
    {
        return apcu_store(
            $this->getFinalKey($key),
            $var,
            !is_null($ttl) ? $ttl : $this->ttl
        );
    }

    /**
     * Retrive data from memory
     *
     * @param string $key
     *
     * @return mixed Stored data or false if not found
     */
    public function fetch($key)
    {
        return apcu_fetch(
            $this->getFinalKey($key)
        );
    }

    /**
     * Remove entry from memory
     *
     * @param string $key
     *
     * @return bool
     */
    public function delete($key)
    {
        return apcu_delete(
            $this->getFinalKey($key)
        );
    }

    /**
     * Check if entry exists in memory
     *
     * @param string $key
     *
     * @return bool
     */
    public function exists($key)
    {
        return apcu_exists(
            $this->getFinalKey($key)
        );
    }

    /**
     * Generate cache key with namespace
     * if available
     *
     * @param string $key
     *
     * @return string
     */
    protected function getFinalKey($key)
    {
        if (!empty($this->namespace)) {
            return sprintf('%s/%s', $this->namespace, $key);
        }

        return $key;
    }
}
