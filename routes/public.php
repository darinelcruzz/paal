<?php

Route::get('/', function () {
    return view('welcome');
});

Route::match(['post', 'get'], 'login', [
    'uses' => 'LoginController@authenticate',
    'as' => 'login'
]);

Route::get('salir', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

Route::get('inicio', function () {
	return view('index');
})->name('home')->middleware('auth');