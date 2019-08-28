<?php

Route::group(['prefix' => 'mbe', 'as' => 'mbe.'], function () {
	
	Route::get('/', usesas('Mailboxes\HomeController', 'index'));

	Route::group(['prefix' => 'egresos', 'as' => 'egress.'], function () {
	    $ctrl = 'Mailboxes\EgressController';
	    Route::get('pagar/{egress}', usesas($ctrl, 'pay'));
	    Route::post('pagar/{egress}', usesas($ctrl, 'charge'));
	    Route::get('reemplazar/{egress}', usesas($ctrl, 'replace'));
	    Route::post('reemplazar/{egress}', usesas($ctrl, 'upload'));
	    Route::get('editar/{egress}', usesas($ctrl, 'edit'));
	    Route::post('editar/{egress}', usesas($ctrl, 'update'));
	    Route::get('/{status}', usesas($ctrl, 'index'));
	    Route::post('/{status}', usesas($ctrl, 'index'));

	    Route::group(['prefix' => 'general', 'as' => 'general.'], function () {
		    $ctrl = 'Mailboxes\GeneralEgressController';
		    Route::get('agregar', usesas($ctrl, 'create'));
		    Route::post('agregar', usesas($ctrl, 'store'));
		});

		Route::group(['prefix' => 'reposiciones', 'as' => 'return.'], function () {
		    $ctrl = 'Mailboxes\ReturnsController';
		    Route::get('agregar', usesas($ctrl, 'create'));
		    Route::post('agregar', usesas($ctrl, 'store'));
		});

		Route::group(['prefix' => 'caja-chica', 'as' => 'register.'], function () {
		    $ctrl = 'Mailboxes\CashRegisterController';
		    Route::get('/cheques', usesas($ctrl, 'index'));
		    Route::get('agregar/{check}', usesas($ctrl, 'create'));
		    Route::post('agregar/{check}', usesas($ctrl, 'store'));
		});
	});

	Route::group(['prefix' => 'cheques', 'as' => 'check.'], function () {
	    $ctrl = 'Mailboxes\CheckController';
	    Route::get('agregar', usesas($ctrl, 'create'));
	    Route::post('agregar', usesas($ctrl, 'store'));
	    Route::get('editar/{check}', usesas($ctrl, 'edit'));
	    Route::post('editar/{check}', usesas($ctrl, 'update'));
	    Route::get('{check}', usesas($ctrl, 'show'));
	});

	Route::group(['prefix' => 'ingresos', 'as' => 'ingress.'], function () {
	    $ctrl = 'Mailboxes\IngressController';
	    Route::get('/', usesas($ctrl, 'index'));
	    Route::get('agregar', usesas($ctrl, 'create'));
	    Route::post('agregar', usesas($ctrl, 'store'));
	    Route::post('cancelar', usesas($ctrl, 'destroy'));
	    Route::get('{ingress}', usesas($ctrl, 'show'));
	});
});