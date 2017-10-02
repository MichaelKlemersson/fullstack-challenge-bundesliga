<?php

namespace App\Services;

use App\Support\Traits\BundesligaJsonApi;
use App\Support\Traits\BundesligaSoapApi;
use App\Support\Traits\CacheApi;

/**
 * Class BundesligaApiService
 */
class BundesligaApiService
{
    use BundesligaJsonApi, BundesligaSoapApi, CacheApi;

    /**
     * Undocumented function
     *
     * @param string $league
     * @param string $session
     * @param int $currentGroup
     * @return array
     */
    public function getLeagueResults(string $league, string $session, int $currentGroup = 1)
    {
        $teams = $this->teamsFromLeague($league, $session);
        $groups = range(1, $currentGroup);

        foreach ($teams as $index => $team) {
            $team['Results'] = $this->getTeamResultsInLeague($league, $session, $team['TeamId'], $groups);
            $teams[$index] = $team;
        }

        return $teams;
    }

    /**
     * Get the total metrics of a team in the current league, session and groups
     *
     * @param string $league
     * @param string $session
     * @param int $teamId
     * @param array $groups
     * @return array
     */
    public function getTeamResultsInLeague(string $league, string $session, int $teamId, array $groups)
    {
        $allTeamMatches = [];
        
        foreach ($groups as $group) {
            $allTeamMatches = array_merge($allTeamMatches, $this->getTeamMatches($league, $session, $teamId, $group));
        }

        return $this->getTeamMetrics($allTeamMatches, $teamId);
    }

    /**
     * Return all matches of a team from a league
     *
     * @param string $league
     * @param string $session
     * @param int $teamId
     * @param int $group
     * @return array
     */
    public function getTeamMatches(string $league, string $session, int $teamId, int $group = 1)
    {
        $cacheKey = "matches-from-team-{$league}-{$session}-{$teamId}-{$group}";

        if (!$this->isCached($cacheKey)) {
            $this->putInCache(
                $cacheKey,
                collect($this->getAllMatchesFromLeague($league, $session, $group))->filter(function ($match) use ($teamId) {
                    if (in_array($teamId, [$match['Team1']['TeamId'], $match['Team2']['TeamId']])) {
                        return $match;
                    }
                })->toArray(),
                30
            );
        }
        
        return $this->getFromCache($cacheKey);
    }

    /**
     * Return from the cache the teams of a league in the current session
     *
     * @param string $league
     * @param string $session
     * @return array
     */
    private function teamsFromLeague(string $league, string $session)
    {
        $cacheKey = "teams-from-league-{$league}-{$session}";

        if (!$this->isCached($cacheKey)) {
            $this->putInCache($cacheKey, $this->getAllTeamsFromLeague($league, $session), 7200); // 7200 minutes = 5 days
        }

        return $this->getFromCache($cacheKey);
    }

    /**
     * Get the total of victories, defeats, draws and point of a team
     *
     * @param array $matches
     * @param int $teamId
     * @return array
     */
    public function getTeamMetrics(array $matches, int $teamId)
    {
        $victories = $defeats = $draws = $points = 0;

        foreach ($matches as $match) {
            if ($match['MatchIsFinished']) {
                if ($this->isDraw($match)) {
                    $draws++;
                    $points += env('DRAW_POINTS', 1);
                } else if ($this->isTeamWinner($match, $teamId)) {
                    $victories++;
                    $points += env('VICTORY_POINTS', 3);
                } else {
                    $defeats++;
                }
            }
        }

        return [
            'team' => $teamId,
            'victories' => $victories,
            'defeats' => $defeats,
            'draws' => $draws,
            'points' => $points,
        ];
    }

    /**
     * Check if a match results in a draw
     *
     * @param array $match
     * @return boolean
     */
    public function isDraw(array $match)
    {
        $finalResult = end($match['MatchResults']);

        return $finalResult['PointsTeam1'] === $finalResult['PointsTeam2'];
    }

    /**
     * Check if a team is the winner of the match
     *
     * @param array $match
     * @param int $teamId
     * @return boolean
     */
    public function isTeamWinner(array $match, int $teamId)
    {
        $finalResult = end($match['MatchResults']);
        
        if (
            ($match['Team1']['TeamId'] === $teamId) &&
            ($finalResult['PointsTeam1'] > $finalResult['PointsTeam2'])
        ) {
            return true;
        } else if (
            ($match['Team2']['TeamId'] === $teamId) &&
            ($finalResult['PointsTeam2'] > $finalResult['PointsTeam1'])
        ) {
            return true;
        }

        return false;
    }
}
