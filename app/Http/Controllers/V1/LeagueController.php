<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\BundesligaApiService;
use App\Support\Traits\CacheApi;
use App\Support\Traits\ResponseHelper;

class LeagueController extends Controller
{
    use CacheApi, ResponseHelper;

    private $apiService;

    public function __construct(BundesligaApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function allLeaguesFromSport(Request $request)
    {
        $request->validate([
            'sport' => 'required',
        ]);

        $cacheKey = "leagues-from-sport-" . $request->input('sport');
        
        if (!$this->isCached($cacheKey)) {
            $this->putInCache($cacheKey, $this->apiService->getLeaguesFromSport(
                $request->input('sport'),
                $request->input('session', '')
            ), 10);
        }

        return $this->makeApiResponse($this->getFromCache($cacheKey));
    }

    public function allMatchesFromLeague(Request $request)
    {
        $request->validate([
            'league' => 'required',
        ]);

        return $this->makeApiResponse(
            $this->apiService->getAllMatchesFromLeague(
                $request->input('league'),
                $request->input('session', ''),
                $request->input('group', '')
            )
        );
    }

    public function getCurrentGroup(Request $request)
    {
        $request->validate([
            'league' => 'required',
        ]);

        $cacheKey = "current-league-group-" . $request->input('league');
        
        if (!$this->isCached($cacheKey)) {
            $this->putInCache($cacheKey, $this->apiService->getCurrentLeagueGroup($request->input('league')), 10);
        }

        return response()->json($this->getFromCache($cacheKey));
    }

    public function getLeagueGroups(Request $request)
    {
        $request->validate([
            'league' => 'required',
            'session' => 'required',
        ]);

        $cacheKey = "league-groups-" . $request->input('league') . '-' . $request->input('group');
        
        if (!$this->isCached($cacheKey)) {
            $this->putInCache($cacheKey, [
                'current' => $this->apiService->getCurrentLeagueGroup($request->input('league')),
                'groups' => $this->apiService->getLeagueGroups(
                    $request->input('league'),
                    $request->input('session')
                )
            ], 10);
        }

        return response()->json($this->getFromCache($cacheKey));
    }

    public function upComingMatchesFromLeague(Request $request)
    {
        $request->validate([
            'league' => 'required',
        ]);

        $cacheKey = "upcoming-league-matches-" . $request->input('league');
        
        if (!$this->isCached($cacheKey)) {
            $this->putInCache($cacheKey, $this->apiService->getAllMatchesFromLeague($request->input('league')), 30);
        }

        return $this->makeApiResponse($this->getFromCache($cacheKey, []));
    }

    public function nextMatchFromLeague(Request $request)
    {
        $request->validate([
            'league' => 'required',
        ]);

        return response()->json(
            $this->apiService->getAllMatchesFromLeague(
                $request->input('league')
            )
        );
    }
}
