<?php
/**
 * Created by PhpStorm.
 * User: Stamen
 * Date: 6/21/2020
 * Time: 10:59 AM
 */

namespace App\Cache;


class CacheCollection implements CacheInterface
{
    /**
     * @var CacheInterface[]
     */
    protected $collection = [];

    /**
     * @param CacheInterface[] $collection
     */
    public function __construct(array $collection)
    {
        $this->collection = $collection;
    }

    /**
     * Retrieves a value.
     *
     * @param string $key
     * @return mixed|null The value associated with the key, or `null` if the key doesn't exists.
     */
    public function retrieve(string $key)
    {
        $value = null;

        foreach ($this->collection as $storage)
        {
            $value = $storage->retrieve($key);

            if ($value !== null)
            {
                break;
            }
        }

        if ($value === null)
        {
            return null;
        }

        return $value;
    }

    /**
     * Stores a variable.
     *
     * @param string $key
     * @param mixed $value
     */
    public function store(string $key, $value): void
    {
        $this->for_each(__FUNCTION__, func_get_args());
    }

    /**
     * Removes a value and its key.
     * @param string $key
     */
    public function eliminate(string $key): void
    {
        $this->for_each(__FUNCTION__, func_get_args());
    }

    /**
     * Apply a same method to each storage instance in the collection.
     *
     * @param string $method
     * @param mixed[] $arguments
     */
    private function for_each(string $method, array $arguments): void
    {
        foreach ($this->collection as $storage)
        {
            $storage->$method(...$arguments);
        }
    }
}