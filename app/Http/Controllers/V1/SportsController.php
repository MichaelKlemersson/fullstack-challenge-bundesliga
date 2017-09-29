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
            $this->putInCache($cacheKey, $this->apiService->getAvailabeSports());
        }

        return response()->json($this->getFromCache($cacheKey));
    }
}
