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

    public function testFetchTeamsFromLeague()
    {
        $apiService = new BundesligaApiService();
        $response = $apiService->getAllTeamsFromLeague($this->league, $this->session);

        $this->assertNotNull($response);
        $this->assertTrue(count($response) > 0);
        $this->assertArrayHasKey('TeamId', $response[0]);
    }

    public function testFetchMatchesFromLeague()
    {
        $apiService = new BundesligaApiService();
        $response = $apiService->getAllMatchesFromLeague($this->league, $this->session);

        $this->assertNotNull($response);
        $this->assertTrue(count($response) > 0);
        $this->assertArrayHasKey('LeagueId', $response[0]);
    }

    public function testFetchNextTeamMatch()
    {
        $apiService = new BundesligaApiService();
        $response = $apiService->getNextTeamMatchFromLeague($this->leagueId, $this->teamId);

        $this->assertNotNull($response);
        $this->assertArrayHasKey('MatchID', $response);
    }

    public function testFetchAvailableSports()
    {
        $apiService = new BundesligaApiService();
        $response = $apiService->getAvailabeSports();

        $this->assertNotNull($response);
        $this->assertTrue(count($response) > 0);
    }

    // public function testFetchLeaguesFromSport()
    // {
    //     $apiService = new BundesligaApiService();
    //     $sports = $apiService->getAvailabeSports();
    //     $response = $apiService->getLeaguesFromSport($sports[0]);

    //     $this->assertNotNull($response);
    //     $this->assertArrayHasKey('LeagueID', $response[0]);
    // }
}
