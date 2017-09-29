<?php

namespace App\Services;

use App\Support\Traits\BundesligaJsonApi;
use App\Support\Traits\BundesligaSoapApi;

/**
 * Class BundesligaApiService
 */
class BundesligaApiService
{
    use BundesligaJsonApi, BundesligaSoapApi;

    /**
     * Return all finished matches of a team from the specified session
     *
     * @param string $league
     * @param string $session
     * @param int $teamId
     * @return array
     */
    public function getTeamResultsFromSession(string $league, string $session, int $teamId)
    {
        return collect($this->getAllMatchesFromLeague($league, $session))->filter(function ($match) use ($teamId) {
            if ($match['MatchIsFinished'] &&
                in_array($teamId, [$match['Team1']['TeamId'], $match['Team2']['TeamId']])
            ) {
                return $match;
            }
        })->toArray();
    }
}
