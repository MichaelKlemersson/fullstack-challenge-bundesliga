<?php

namespace App\Support\Traits;

use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

/**
 * Trait CacheApi
 */
trait CacheApi
{
    /**
     * Check if cache has key
     *
     * @param string $key
     * @return boolean
     */
    public function isCached(string $key)
    {
        return Cache::has($key);
    }

    /**
     * Get contents from cache if it exists
     *
     * @param string $key
     * @param string $defaultContent
     * @return mixed
     */
    public function getFromCache(string $key, $defaultContent = '')
    {
        return Cache::get($key, $defaultContent);
    }

    /**
     * Store contents on cache
     *
     * @param string $key
     * @param mixed $content
     * @param integer $minutes
     * @return void
     */
    public function putInCache(string $key, $content, $minutes = 2)
    {
        Cache::put($key, $content, (Carbon::now()->addMinutes($minutes)));
    }
}
