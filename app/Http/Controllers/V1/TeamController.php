<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\BundesligaApiService;
use App\Support\Traits\CacheApi;

class TeamController extends Controller
{
    use CacheApi;

    private $apiService;
    
    public function __construct(BundesligaApiService $apiService)
    {
        $this->apiService = $apiService;
    }
    
    public function allTeamsFromLeague(Request $request)
    {
        $request->validate([
            'league' => 'required',
            'session' => 'required',
        ]);

        return response()->json(
            $this->getFromCache(
                "teams-from-league-" . $request->input('team') . '-' . $request->input('session'),
                $this->apiService->getTeamMatches(
                    $request->input('league'),
                    $request->input('session')
                )
            )
        );
    }

    public function allMatchesFromTeam(Request $request)
    {
        $request->validate([
            'league' => 'required',
            'session' => 'required',
            'team' => 'required',
        ]);

        return response()->json(
            $this->getFromCache(
                "matches-from-team-" . $request->input('team'),
                $this->apiService->getTeamMatches(
                    $request->input('league'),
                    $request->input('session'),
                    $request->input('team')
                )
            )
        );
    }
}
