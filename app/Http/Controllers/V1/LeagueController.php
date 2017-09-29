<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\BundesligaApiService;
use App\Support\Traits\CacheApi;

class LeagueController extends Controller
{
    use CacheApi;

    private $apiService;

    public function __construct(BundesligaApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function allLeaguesFromSport($sportId)
    {
        return response()->json(
            $this->getFromCache("leagues-from-{$sportId}", $this->apiService->getLeaguesFromSport($sportId))
        );
    }

    public function getCurrentGroup($league)
    {
        return response()->json(
            $this->getFromCache("current-league-group-{$league}", $this->apiService->getLeaguesFromSport($sportId))
        );
    }
}
