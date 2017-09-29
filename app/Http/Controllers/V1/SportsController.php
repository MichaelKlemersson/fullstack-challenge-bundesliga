<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\BundesligaApiService;
use App\Support\Traits\CacheApi;

class SportsController extends Controller
{
    use CacheApi;

    private $apiService;

    public function __construct(BundesligaApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function availableSports()
    {
        $cacheKey = "available-sports";

        if (!$this->isCached($cacheKey)) {
            $this->putInCache($cacheKey, $this->apiService->getAvailabeSports(), 30);
        }

        return response()->json($this->getFromCache($cacheKey));
    }

    public function defaultSport()
    {
        $cacheKey = "default-sport";

        if (!$this->isCached($cacheKey)) {
            $this->putInCache($cacheKey, collect($this->apiService->getAvailabeSports(), 60)
                ->filter(function ($sport) {
                    return $sport['sportsID'] == 1;
                })
                ->first());
        }
            
        return response()->json($this->getFromCache($cacheKey));
    }
}
