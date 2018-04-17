<?php

Route::get('/', function () {
    return view('welcome');
});

Route::match(['post', 'get'], 'login', [
    'uses' => 'LoginController@authenticate',
    'as' => 'login'
]);

Route::get('inicio', function () {
	return view('index');
})->name('home');

Route::group(['prefix' => 'proveedores', 'as' => 'provider.'], function () {
    $ctrl = 'Coffee\ProviderController';
    Route::get('/', usesas($ctrl, 'index'));
    Route::get('agregar', usesas($ctrl, 'create'));
    Route::post('agregar', usesas($ctrl, 'store'));
});

Route::group(['prefix' => 'egresos', 'as' => 'egress.'], function () {
    $ctrl = 'Coffee\EgressController';
    Route::get('/', usesas($ctrl, 'index'));
    Route::get('agregar', usesas($ctrl, 'create'));
    Route::post('agregar', usesas($ctrl, 'store'));
    Route::post('subir', usesas($ctrl, 'upload'));
});