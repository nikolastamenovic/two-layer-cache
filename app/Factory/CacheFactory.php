<?php
/**
 * Created by PhpStorm.
 * User: Stamen
 * Date: 6/21/2020
 * Time: 11:13 AM
 */

namespace App\Factory;


use App\Cache\APCuCache;
use App\Cache\CacheCollection;
use App\Cache\RedisCache;

class CacheFactory
{
    public static function create(): CacheCollection
    {
        $prefix = 'my_cache::';
        return new CacheCollection([
            new APCuCache($prefix),
            new RedisCache($prefix)
        ]);
    }
}