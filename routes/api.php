<?php

Route::prefix('v1')->namespace('V1')->group(function () {
    Route::prefix('sports')->group(function () {
        Route::get('/', 'SportsController@availableSports')->name('sports.all');
        Route::get('/default', 'SportsController@defaultSport')->name('sports.default');
    });

    Route::prefix('leagues')->group(function () {
        Route::get('/', 'LeagueController@allLeaguesFromSport')->name('leagues.allFromSport');
        
        Route::get('/matches', 'LeagueController@allMatchesFromLeague')->name('leagues.allMatches');
        Route::get('/matches/next', 'LeagueController@nextMatchFromLeague')->name('leagues.nextMatch');
        Route::get('/matches/upcoming', 'LeagueController@upComingMatchesFromLeague')->name('leagues.upcomingMatch');
        
        Route::get('/groups', 'LeagueController@getLeagueGroups')->name('leagues.groups');
        Route::get('/groups/current', 'LeagueController@getCurrentGroup')->name('leagues.currentGroup');
    });

    Route::prefix('teams')->group(function () {
        Route::get('/', 'TeamController@allTeamsFromLeague')->name('teams.allFromLeague');
    });

    Route::prefix('results')->group(function () {
        Route::get('/league', 'ResultsController@leagueResults')->name('results.allFromLeague');
        Route::get('/team', 'ResultsController@teamResults')->name('results.allFromTeam');
    });
});
