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
    '/music/{file}/{track}',
    array(
        'as'   => 'musicSheets',
        'uses' => 'IndexController@getMusicSheets'
    )
);

Route::get('login/fb', function() {
    $facebook = new Facebook(Config::get('facebook'));
    $params = array(
        'redirect_uri' => url('/login/fb/callback'),
        'scope' => 'email',
    );
    return Redirect::away($facebook->getLoginUrl($params));
});

Route::get('login/fb/callback', function() {
    $code = Input::get('code');
    if (strlen($code) == 0 && App::environment() == 'local')
    {
        $user = User::first();
    }
    else
    {
        if (strlen($code) == 0) return Redirect::to('/')->withError('There was an error communicating with Facebook');

        $facebook = new Facebook(Config::get('facebook'));
        $uid = $facebook->getUser();

        if ($uid == 0) return Redirect::to('/')->withError('There was an error');

        $me = $facebook->api('/me');

        $profile = Profile::whereUid($uid)->first();
        if (empty($profile)) {
            $user = new User;
            $user->name = $me['first_name'].' '.$me['last_name'];
            $user->email = $me['email'];

            $user->save();

            $profile = new Profile();
            $profile->uid = $uid;
            $profile->username = $me['email'];
            $profile = $user->profiles()->save($profile);
        }

        $profile->access_token = $facebook->getAccessToken();
        $profile->save();

        $user = $profile->user;
    }
    Auth::login($user);

    return Redirect::to('/')->with('success', 'Logged in with Facebook');
});

Route::get('/logout', function() {
    Auth::logout();
    return Redirect::to('/');
});