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
	    Route::get('cancelar/{egress}', usesas($ctrl, 'cancel'));
	    Route::post('cancelar/{egress}', usesas($ctrl, 'destroy'));
	    Route::post('pagar/{egress}', usesas($ctrl, 'settle'));
	});

	Route::group(['prefix' => 'ingresos', 'as' => 'ingress.'], function () {
	    $ctrl = 'IngressController';
	    Route::get('/', usesas($ctrl, 'index'));
	    Route::get('agregar/{company}', usesas($ctrl, 'create'));
	    Route::post('agregar', usesas($ctrl, 'store'));
	    Route::post('cancelar', usesas($ctrl, 'destroy'));
	});

	Route::group(['prefix' => 'reportes', 'as' => 'report.'], function () {
	    $ctrl = 'ReportController';
	    Route::get('/', usesas($ctrl, 'index'));
	    Route::post('pendientes', usesas($ctrl, 'pending'));
	    Route::post('pagadas', usesas($ctrl, 'paid'));
	    Route::post('proveedores', usesas($ctrl, 'providers'));
	});

	Route::group(['prefix' => 'productos', 'as' => 'product.'], function () {
	    $ctrl = 'ProductController';
	    Route::get('/', usesas($ctrl, 'index'));
	    Route::get('agregar', usesas($ctrl, 'create'));
	    Route::post('agregar', usesas($ctrl, 'store'));
	    Route::get('editar/{product}', usesas($ctrl, 'edit'));
	    Route::post('editar/{product}', usesas($ctrl, 'update'));
	    Route::get('axios', usesas($ctrl, 'axios'));
	});

	Route::group(['prefix' => 'clientes', 'as' => 'client.'], function () {
	    $ctrl = 'ClientController';
	    Route::get('/', usesas($ctrl, 'index'));
	    Route::get('agregar', usesas($ctrl, 'create'));
	    Route::post('agregar', usesas($ctrl, 'store'));
	    Route::get('editar/{client}', usesas($ctrl, 'edit'));
	    Route::post('editar/{client}', usesas($ctrl, 'update'));
	});

	Route::group(['prefix' => 'usuarios', 'as' => 'user.', 'middleware' => 'admin'], function () {
	    $ctrl = 'UserController';
	    Route::get('/', usesas($ctrl, 'index'));
	    Route::get('agregar', usesas($ctrl, 'create'));
	    Route::post('agregar', usesas($ctrl, 'store'));
	    Route::get('editar/{user}', usesas($ctrl, 'edit'));
	    Route::post('editar/{user}', usesas($ctrl, 'update'));
	});
});
