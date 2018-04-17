<?php

Route::group(['prefix' => 'coffee', 'as' => 'coffee.'], function () {
	
	Route::get('/', usesas('Coffee\HomeController', 'index'));

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
});
