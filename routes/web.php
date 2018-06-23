<?php

Route::get('/', 'HomeController@index');

Auth::routes();

Route::group(['prefix' => 'requester'], function () {
    Route::get('tickets/{token}', 'RequesterTicketsController@show')->name('requester.tickets.show');
    Route::post('tickets/{token}/comments', 'RequesterCommentsController@store')->name('requester.comments.store');
});

Route::group(['middleware' => ['auth', 'userLocale']], function () {

    Route::get('profile', 'ProfileController@show')->name('profile.show');
    Route::put('profile', 'ProfileController@update')->name('profile.update');
    Route::post('password', 'ProfileController@password')->name('profile.password');

    Route::get('tickets/merge', 'TicketsMergeController@index')->name('tickets.merge.index');
    Route::post('tickets/merge', 'TicketsMergeController@store')->name('tickets.merge.store');
    Route::get('tickets/search/{text}', 'TicketsSearchController@index')->name('tickets.search');
    Route::resource('tickets', 'TicketsController', ['except' => ['edit', 'destroy']]);
    Route::get('tickets/create/{ticketType}', 'TicketsController@create')->name('tickets.create');
    Route::get('ticket/selection', 'TicketsController@choice')->name('tickets.choice');
    Route::post('tickets/{ticket}/assign', 'TicketsAssignController@store')->name('tickets.assign');
    Route::post('tickets/{ticket}/comments', 'CommentsController@store')->name('comments.store');
    Route::resource('tickets/{ticket}/tags', 'TicketsTagsController', ['only' => ['store', 'destroy'], 'as' => 'tickets']);
    Route::post('tickets/{ticket}/reopen', 'TicketsController@reopen')->name('tickets.reopen');
    Route::post('tickets/{ticket}/escalate', 'TicketsEscalateController@store')->name('tickets.escalate.store');
    Route::delete('tickets/{ticket}/escalate', 'TicketsEscalateController@destroy')->name('tickets.escalate.destroy');

    Route::group(['middleware' => 'can:see-admin'], function () {
        Route::resource('users', 'UsersController');
        Route::get('users/{user}/impersonate', 'UsersController@impersonate')->name('users.impersonate');
        Route::put('users/{user}/edit', 'UsersController@role')->name('users.role');

        Route::resource('settings', 'SettingsController', ['only' => ['edit', 'update']]);

        Route::resource('news', 'NewsController');
        Route::post('news', 'NewsController@store')->name('news.store');
        Route::post('news/display', 'NewsDisplayController@store')->name('news.display.store');

        Route::resource('teams', 'TeamsController');
        Route::get('teams/{team}/agents', 'TeamAgentsController@index')->name('teams.agents');
        Route::delete('teams/{user}/destroy/{team}', 'TeamMembershipController@destroy')->name('membership.destroy');
        //Route::get('teams/{token}/join', 'TeamMembershipController@index')->name('membership.index');
        Route::post('teams/{token}/join', 'TeamMembershipController@store')->name('membership.store');
    });

    Route::get('reports', 'ReportsController@index')->name('reports.index');

    Route::get('statistics', 'StatisticsController@index')->name('statistics.index');

    Route::get('knowledgebase', 'KnowledgebaseController@index')->name('knowledgebase.index');
});
