<?php

namespace App\Support\Traits;

use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

trait CacheApi
{
    public function isCached(string $key)
    {
        return Cache::has($key);
    }

    public function getFromCache(string $key, $defaultContent = '')
    {
        if (!$this->isCached($cacheKey)) {
            $this->putInCache($cacheKey, $defaultContent);
        }
        
        return Cache::get($key);
    }

    public function putInCache(string $key, $content, $minutes = 30)
    {
        Cache::put($key, $content, (Carbon::now()->addMinutes($minutes)));

        return $this;
    }

}
