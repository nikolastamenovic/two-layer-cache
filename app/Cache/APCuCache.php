<?php
/**
 * Created by PhpStorm.
 * User: Stamen
 * Date: 6/21/2020
 * Time: 12:48 PM
 */

namespace App\Cache;


class APCuCache implements CacheInterface
{
    /**
     * @var string
     */
    private $prefix;

    public function __construct(string $prefix)
    {
        $this->prefix = $prefix;
    }

    /**
     * Retrieves a value.
     *
     * @param string $key
     * @return mixed|null The value associated with the key, or `null` if the key doesn't exists.
     */
    public function retrieve(string $key)
    {
        $rc = apcu_fetch($this->prefix . $key, $success);

        return $success ? $rc : null;
    }

    /**
     * Stores a variable.
     *
     * @param string $key
     * @param mixed $value
     * @param int|null $ttl
     */
    public function store(string $key, $value): void
    {
        apcu_store($this->prefix . $key, $value);
    }

    /**
     * Removes a value and its key.
     * @param string $key
     */
    public function eliminate(string $key): void
    {
        apcu_delete($this->prefix . $key);
    }
}