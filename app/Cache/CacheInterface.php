<?php
/**
 * Created by PhpStorm.
 * User: Stamen
 * Date: 6/21/2020
 * Time: 10:46 AM
 */

namespace App\Cache;


interface CacheInterface
{
    /**
     * Retrieves a value.
     *
     * @param string $key
     * @return mixed|null The value associated with the key, or `null` if the key doesn't exists.
     */
    public function retrieve(string $key);

    /**
     * Stores a variable.
     *
     * @param string $key
     * @param mixed $value
     */
    public function store(string $key, $value): void;

    /**
     * Removes a value and its key.
     * @param string $key
     */
    public function eliminate(string $key): void;
}