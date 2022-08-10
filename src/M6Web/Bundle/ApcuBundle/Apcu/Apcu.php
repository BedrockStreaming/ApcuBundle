<?php

declare(strict_types=1);

namespace M6Web\Bundle\ApcuBundle\Apcu;

/**
 * Provide APCu abstraction
 * with namespace feature
 */
class Apcu
{
    protected string $namespace;

    protected int $ttl;

    /**
     * Construct
     *
     * @param string $namespace Namespace
     * @param int    $ttl       Default TTL
     */
    public function __construct(string $namespace = '', int $ttl = 3600)
    {
        $this->namespace = $namespace;
        $this->ttl = $ttl;
    }

    /**
     * Define cache namespace
     */
    public function setNamespace(string $namespace): self
    {
        $this->namespace = $namespace;

        return $this;
    }

    /**
     * Get cache namespace
     */
    public function getNamespace(): string
    {
        return $this->namespace;
    }

    /**
     * Define default TTL
     */
    public function setTtl(int $ttl): self
    {
        $this->ttl = $ttl;

        return $this;
    }

    /**
     * Get default TTL
     */
    public function getTtl(): int
    {
        return $this->ttl;
    }

    /**
     * Store data in memory
     */
    public function store(string $key, $var, ?int $ttl = null): bool
    {
        return apcu_store(
            $this->getFinalKey($key),
            $var,
            !is_null($ttl) ? $ttl : $this->ttl
        );
    }

    /**
     * Retreive data from memory
     *
     * @return mixed Stored data or false if not found
     */
    public function fetch(string $key): mixed
    {
        return apcu_fetch(
            $this->getFinalKey($key)
        );
    }

    /**
     * Remove entry from memory
     *
     * @return bool|string[]
     */
    public function delete(string $key): bool|array
    {
        return apcu_delete(
            $this->getFinalKey($key)
        );
    }

    /**
     * Check if entry exists in memory
     */
    public function exists(string $key): bool
    {
        return apcu_exists(
            $this->getFinalKey($key)
        );
    }

    /**
     * Generate cache key with namespace
     * if available
     */
    protected function getFinalKey(string $key): string
    {
        if (!empty($this->namespace)) {
            return sprintf('%s/%s', $this->namespace, $key);
        }

        return $key;
    }
}
