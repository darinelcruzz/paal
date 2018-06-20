<?php

Route::group(['prefix' => 'paal', 'as' => 'paal.'], function () {

	Route::get('/', usesas('Paal\HomeController', 'index'));

	Route::group(['prefix' => 'proveedores', 'as' => 'provider.'], function () {
	    $ctrl = 'ProviderController';
	    Route::get('/', usesas($ctrl, 'index'));
	    Route::get('agregar', usesas($ctrl, 'create'));
	    Route::post('agregar', usesas($ctrl, 'store'));
		Route::get('editar/{provider}', usesas($ctrl, 'edit'));
	    Route::post('editar', usesas($ctrl, 'update'));
	    Route::get('cancelar/{provider}', usesas($ctrl, 'destroy'));
	});

	Route::group(['prefix' => 'egresos', 'as' => 'egress.'], function () {
	    $ctrl = 'EgressController';
	    Route::get('/', usesas($ctrl, 'index'));
	    Route::post('cancelar', usesas($ctrl, 'destroy'));
	});

	Route::group(['prefix' => 'reportes', 'as' => 'report.'], function () {
	    $ctrl = 'ReportController';
	    Route::get('/', usesas($ctrl, 'index'));
	    Route::post('pendientes', usesas($ctrl, 'pending'));
	    Route::post('pagadas', usesas($ctrl, 'paid'));
	    Route::get('proveedores', usesas($ctrl, 'providers'));
	});
});
