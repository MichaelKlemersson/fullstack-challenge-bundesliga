<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\BundesligaApiService;

class BundesligaApiServiceTest extends TestCase
{
    public function testFetchLeagueResults()
    {
        $league = 'bl1';
        $leagueSession = 2017;
        $currentLeagueGroup = 7;
        $apiService = new BundesligaApiService();
        $results = $apiService->getLeagueResults($league, $leagueSession, $currentLeagueGroup);

        $this->assertNotNull($results);
        $this->assertArrayHasKey('Results', $results[0]);
    }
}
