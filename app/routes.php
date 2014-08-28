<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get(
    '/',
    array(
        'as'   => 'index',
        'uses' => 'IndexController@getIndex'
    )
);

Route::post(
    '/',
    array(
        'as'   => 'postMidiFile',
        'uses' => 'IndexController@postMidiFile'
    )
);

Route::get(
    '/tracks/{file?}',
    array(
        'as'   => 'tracks',
        'uses' => 'IndexController@getTracks'
    )
);

Route::post(
    '/tracks/{file}',
    array(
        'as'   => 'postTracks',
        'uses' => 'IndexController@postTracks'
    )
);

Route::get(
    '/music/{file}',
    array(
        'as'   => 'musicSheets',
        'uses' => 'IndexController@getMusicSheets'
    )
);
