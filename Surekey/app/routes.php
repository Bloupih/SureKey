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

Route::group(["before" => "guest"], function()
{
    Route::any("/", [
        "as"   => "user/login",
        "uses" => "UserController@loginAction"
    ]);
});

Route::group(["before" => "auth"], function()
{
    Route::any("/administrator", [
        "as"   => "user/administrator",
        "uses" => "UserController@administratorAction"
    ]);

    Route::any("/logout", [
        "as"   => "user/logout",
        "uses" => "UserController@logoutAction"
    ]);

    Route::any("/settings", [
        "as"   => "user/settings",
        "uses" => "UserController@showAction"
    ]);

    Route::any("/addDevice", [
        "as"   => "user/addDevice",
        "uses" => "DeviceController@addDevice"
    ]);
});

Route::get('/verifyConnection', 'UserController@verifyConnection');

Route::get('/newPassword', 'KeyController@newUniquePassword');

Route::get('/deleteDevice', 'DeviceController@deleteDevice');