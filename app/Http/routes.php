<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return view('test');
});

Route::get('/test/record', function () {
    return view('testrecord');
});

Route::get('/test/report', function () {
    return view('testreport');
});

Route::get('/test/itemdata', function () {
    return view('testitemdata');
});

Route::get('/test/item', function () {
    return view('testitem');
});

Route::get('/home', function () {
    return view('home');
});

Route::get('/user/test', function () {
    $user = Auth::user();
    return response($user);
});

// 認證路由...
Route::get('/', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// 註冊路由...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

//item route 
Route::post('item/create', 'ItemController@create');
Route::post('item/update', 'ItemController@update');
Route::post('item/delete', 'ItemController@delete');
Route::get('item/has', 'ItemController@has');
Route::get('item/get/{id?}', 'ItemController@get');

Route::post('itemdata/create', 'ItemDataController@create');
Route::post('itemdata/update', 'ItemDataController@update');
Route::post('itemdata/delete', 'ItemDataController@delete');
Route::get('itemdata/has', 'ItemDataController@has');
Route::get('itemdata/get/{id?}', 'ItemDataController@get');
Route::get('itemdata/item/{id}', 'ItemDataController@item');

//report route
Route::get('report/{date}', 'ReportController@get');
Route::post('report/update', 'ReportController@update');
Route::post('report/create', 'ReportController@create');

//records route
Route::get('record/item/{item_id}', 'RecordController@getForItemId');
Route::get('record/user/{uid?}', 'RecordController@getForUserId');
Route::get('record/date/{date}', 'RecordController@getForDate');
Route::get('record/get', 'RecordController@get');
Route::post('record/create', 'RecordController@create');
Route::post('record/update', 'RecordController@update');
Route::post('record/delete', 'RecordController@delete');

Route::post('user/check', function() {
    $email = Request::input('email');
    $pwd = Request::input('password');
    $userid = null;

    if ($key = Auth::attempt(['email' => $email, 'password' => $pwd])) {
        $user = Auth::user();
        $userid = $user->id;
        $username = $user->name;
    }

    return response(array(
        'ret' => $key,
        'userid' => $userid,
        'username' => $username
    ));
});

Route::get('user/out', function() {
    Auth::logout();
});

Route::post('mobile/records', 'RecordController@createForMobile');
Route::get('mobile/get/{id}', 'RecordController@getForMobile');
