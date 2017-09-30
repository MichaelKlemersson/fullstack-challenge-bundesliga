<?php

Route::prefix('v1')->namespace('V1')->group(function () {
    Route::prefix('leagues')->group(function () {
        Route::get('/', 'LeagueController@allLeaguesFromSport')->name('leagues.allFromSport');
        Route::get('/matches', 'LeagueController@allMatchesFromLeague')->name('leagues.allMatches');
        Route::get('/matches/next', 'LeagueController@nextMatchFromLeague')->name('leagues.nextMatch');
        Route::get('/matches/upcoming', 'LeagueController@upComingMatchesFromLeague')->name('leagues.upcomingMatch');
    });

    Route::prefix('teams')->group(function () {
        Route::get('/', 'TeamController@allTeamsFromLeague')->name('teams.allFromLeague');
        Route::get('/matches', 'TeamController@allMatchesFromTeam')->name('teams.matches');
    });

    Route::prefix('sports')->group(function () {
        Route::get('/', 'SportsController@availableSports')->name('sports.all');
        Route::get('/default', 'SportsController@defaultSport')->name('sports.default');
    });
});
