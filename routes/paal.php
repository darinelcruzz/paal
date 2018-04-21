<?php

Route::group(['prefix' => 'paal', 'as' => 'paal.'], function () {
	
	Route::get('/', usesas('Paal\HomeController', 'index'));

	Route::group(['prefix' => 'proveedores', 'as' => 'provider.'], function () {
	    $ctrl = 'ProviderController';
	    Route::get('/', usesas($ctrl, 'index'));
	    Route::get('agregar', usesas($ctrl, 'create'));
	    Route::post('agregar', usesas($ctrl, 'store'));
	});

	Route::group(['prefix' => 'egresos', 'as' => 'egress.'], function () {
	    $ctrl = 'EgressController';
	    Route::get('/', usesas($ctrl, 'index'));
	    Route::post('cancelar', usesas($ctrl, 'destroy'));
	});
});