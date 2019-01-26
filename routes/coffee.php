<?php

Route::group(['prefix' => 'coffee', 'as' => 'coffee.'], function () {

	Route::get('/', usesas('Coffee\HomeController', 'index'));

	Route::group(['prefix' => 'egresos', 'as' => 'egress.'], function () {
	    $ctrl = 'Coffee\EgressController';
	    Route::get('/', usesas($ctrl, 'index'));
	    Route::get('agregar', usesas($ctrl, 'create'));
	    Route::post('agregar', usesas($ctrl, 'store'));
	    Route::get('pagar/{egress}', usesas($ctrl, 'pay'));
	    Route::post('pagar', usesas($ctrl, 'settle'));
	});

	Route::group(['prefix' => 'ingresos', 'as' => 'ingress.'], function () {
	    $ctrl = 'Coffee\IngressController';
	    Route::get('/', usesas($ctrl, 'index'));
	    Route::get('agregar', usesas($ctrl, 'create'));
	    Route::post('agregar', usesas($ctrl, 'store'));
	    Route::get('pagar/{ingress}', usesas($ctrl, 'pay'));
	    Route::post('pagar', usesas($ctrl, 'settle'));
		Route::get('ticket/{ingress}', usesas($ctrl, 'ticket'));
		Route::get('{ingress}', usesas($ctrl, 'show'));
	});

	Route::group(['prefix' => 'clientes', 'as' => 'client.'], function () {
	    $ctrl = 'Coffee\ClientController';
	    Route::get('/', usesas($ctrl, 'index'));
	    Route::get('agregar', usesas($ctrl, 'create'));
	    Route::post('agregar', usesas($ctrl, 'store'));
	    Route::get('editar/{client}', usesas($ctrl, 'edit'));
	    Route::post('editar/{client}', usesas($ctrl, 'update'));
	});
});
