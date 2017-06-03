<?php namespace App\Http\Controllers;

use Route, Request, Response;

function test_route($path, callable $f) {
    Route::get($path, $f);
}

function get($path, $controller, $method, $name = null) {
    Route::get($path, $controller.'@'.$method)->name($name);
}

function post($path, $controller, $method, $name = null) {
    Route::post($path, $controller.'@'.$method)->name($name);
}

function basic_auth($user, $pass) {
    if (\Request::getUser() != $user || \Request::getPassword() != $pass) {
        $headers = array('WWW-Authenticate' => 'Basic');
        return \Response::make('Invalid credentials.', 401, $headers);
    }
}

function group(array $middleware, Callable $f) {
    Route::group(['middleware' => implode('|', $middleware)], $f);
}