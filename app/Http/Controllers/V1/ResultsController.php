<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\BundesligaApiService;
use App\Support\Traits\CacheApi;
use App\Support\Traits\ResponseHelper;

class ResultsController extends Controller
{
    use CacheApi, ResponseHelper;

    private $apiService;

    public function __construct(BundesligaApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function leagueResults(Request $request)
    {
        $request->validate([
            'league' => 'required'
        ]);

        $cacheKey = "league-results-" . $request->input('league');

        if (!$this->isCached($cacheKey)) {
            $this->putInCache($cacheKey, $this->apiService->getLeagueResults($request->input('league')), 60);
        }

        return $this->makeApiResponse($this->getFromCache($cacheKey));
    }

    public function teamResults(Request $request)
    {
        $request->validate([
            'league' => 'required',
            'session' => 'required',
            'team' => 'required',
            'group' => 'required',
        ]);

        $params = $request->all();

        $cacheKey = "team-results-{$params['league']}-{$params['session']}-{$params['group']}-{$params['team']}";
        
        if (!$this->isCached($cacheKey)) {
            $this->putInCache($cacheKey, $this->apiService->getTeamResultsInLeague(
                $params['league'],
                $params['session'],
                $params['team'],
                range(1, $params['group'])
            ), 60);
        }

        return $this->makeApiResponse($this->getFromCache($cacheKey));
    }
}
