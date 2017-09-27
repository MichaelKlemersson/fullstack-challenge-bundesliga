<?php

namespace App\Support\Traits;

use App\Support\JsonApiClient;
use App\Support\Api\Response\ParseJsonResponse;

/**
 * Trait BundesligaJsonApi Helpers 
 */
trait BundesligaJsonApi
{
    protected $jsonApiUri = 'https://www.openligadb.de/api/';

    protected function getJsonClient()
    {
        return new JsonApiClient();
    }

    /**
     * A helper function to parse json response to array
     *
     * @param mixed $response
     * @return array
     */
    protected function parseJsonResponse($response)
    {
        return (new ParseJsonResponse())->parse($response);
    }

    /**
     * Return all team of a league from the current session
     *
     * @param string $league
     * @param string $session
     * @return array
     */
    public function getAllTeamsFromLeague(string $league, string $session)
    {
        return $this->parseJsonResponse(
            $this
                ->getJsonClient()
                ->fetch($this->jsonApiUri, [
                    'action' => "getavailableteams/{$league}/{$session}"
                ])
        );
    }

    /**
     * Return all matches of a league, from a specific session and matchday, or not
     *
     * @param string $league
     * @param string $session
     * @param string $game
     * @return array
     */
    public function getAllMatchesFromLeague(string $league, string $session = '', string $game = '')
    {
        return $this->parseJsonResponse(
            $this
                ->getJsonClient()
                ->fetch($this->jsonApiUri, [
                    'action' => "getmatchdata/{$league}/{$session}/{$game}"
                ])
        );
    }

    /**
     * Return the next match for the team of a specified league
     *
     * @param string $league
     * @param int $teamId
     * @return array
     */
    public function getNextTeamMatchFromLeague(string $league, int $teamId)
    {
        return $this->parseJsonResponse(
            $this
                ->getJsonClient()
                ->fetch($this->jsonApiUri, [
                    'action' => "getnextmatchbyleagueteam/{$league}/{$teamId}"
                ])
        );
    }
}
