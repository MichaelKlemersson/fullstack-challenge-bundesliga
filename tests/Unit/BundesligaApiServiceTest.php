<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\BundesligaApiService;

class BundesligaApiServiceTest extends TestCase
{
    protected $league = 'bl1';

    protected $leagueId = 3005;

    protected $teamId = 7;

    protected $session = '2016';

    // public function testFetchTeamsFromLeague()
    // {
    //     $apiService = new BundesligaApiService();
    //     $response = $apiService->getAllTeamsFromLeague($this->league, $this->session);

    //     $this->assertNotNull($response);
    //     $this->assertTrue(count($response) > 0);
    //     $this->assertArrayHasKey('TeamId', $response[0]);
    // }

    // public function testFetchMatchesFromLeague()
    // {
    //     $apiService = new BundesligaApiService();
    //     $response = $apiService->getAllMatchesFromLeague($this->league, $this->session);

    //     $this->assertNotNull($response);
    //     $this->assertTrue(count($response) > 0);
    //     $this->assertArrayHasKey('LeagueId', $response[0]);
    // }

    // public function testFetchNextTeamMatch()
    // {
    //     $apiService = new BundesligaApiService();
    //     $response = $apiService->getNextTeamMatchFromLeague($this->leagueId, $this->teamId);

    //     $this->assertNotNull($response);
    //     $this->assertArrayHasKey('MatchID', $response);
    // }

    // public function testFetchAvailableSports()
    // {
    //     $apiService = new BundesligaApiService();
    //     $response = $apiService->getAvailabeSports();

    //     $this->assertNotNull($response);
    //     $this->assertTrue(count($response) > 0);
    //     $this->assertArrayHasKey('sportsID', $response[0]);
    // }

    // public function testFetchLeaguesFromSport()
    // {
    //     $apiService = new BundesligaApiService();
    //     $sports = $apiService->getAvailabeSports();
    //     $response = $apiService->getLeaguesFromSport($sports[0]['sportsID']);

    //     $this->assertNotNull($response);
    //     $this->assertArrayHasKey('leagueID', $response[0]);
    // }

    // public function testFetchTeamMatches()
    // {
    //     $apiService = new BundesligaApiService();
    //     // $teams = $apiService->getAllTeamsFromLeague($this->league, $this->session);
    //     // $randomTeam = $teams[(random_int(count($teams)))];

    //     $teamResults = $apiService->getTeamMatches($this->league, $this->session, $this->teamId);
    //     $firstResult = array_shift($teamResults);
    //     $this->assertNotNull($teamResults);
    //     $this->assertTrue($firstResult['MatchIsFinished']);
    //     $this->assertArrayHasKey('LeagueId', $firstResult);
    //     $this->assertEquals($this->leagueId, $firstResult['LeagueId']);
    // }

    // public function testFetchCurrentGroupFromLeague()
    // {
    //     $apiService = new BundesligaApiService();
    //     $group = $apiService->getCurrentLeagueGroup($this->league);

    //     $this->assertNotNull($group);
    //     $this->assertArrayHasKey('GroupID', $group);
    // }

    // public function testFetchAvailableGroupsFromLeague()
    // {
    //     $apiService = new BundesligaApiService();
    //     $groups = $apiService->getLeagueGroups($this->league, $this->session);

    //     $this->assertNotNull($groups);
    //     $this->assertArrayHasKey('GroupID', $groups[0]);
    // }

    public function testFetchNextMatchFromLeague()
    {
        $apiService = new BundesligaApiService();
        $match = $apiService->getNextLeagueMatch($this->league);

        $this->assertNotNull($match);
        $this->assertArrayHasKey('matchID', $match);
        $this->assertFalse($match['matchIsFinished']);
    }
}
