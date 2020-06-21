<?php
/**
 * Created by PhpStorm.
 * User: Stamen
 * Date: 6/21/2020
 * Time: 10:48 AM
 */

namespace App\Cache;


use Illuminate\Support\Facades\Redis;

class RedisCache implements CacheInterface
{
    /**
     * @var string
     */
    private $prefix;

    /**
     * RedisCache constructor.
     * @param string $prefix
     */
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
        $value = Redis::get($this->prefix . $key);

        if (!$value)
        {
            return null;
        }

        return unserialize($value);
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
        $key = $this->prefix . $key;

        Redis::set($key, serialize($value));
    }

    /**
     * Removes a value and its key.
     * @param string $key
     */
    public function eliminate(string $key): void
    {
        Redis::del($this->prefix . $key);
    }
}