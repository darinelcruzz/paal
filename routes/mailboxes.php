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
		    Route::get('gasto-extra', usesas($ctrl, 'make'));
		    Route::post('gasto-extra', usesas($ctrl, 'save'));
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
	    $ctrl = 'Mailboxes\AdminController';
	    Route::get('mensual', usesas($ctrl, 'monthly'));
	    Route::post('mensual', usesas($ctrl, 'monthly'));
	    Route::match(['get', 'post'], 'diario/{status}/{thisDate?}', usesas($ctrl, 'daily'));
	    Route::post('por-paqueteria', usesas($ctrl, 'companies'));
	    Route::post('referencia', usesas($ctrl, 'reference'));
	    Route::get('depositos/{date}', usesas($ctrl, 'printDeposits'));
	});

	Route::group(['prefix' => 'ingresos', 'as' => 'ingress.'], function () {
	    $ctrl = 'Mailboxes\IngressController';
	    Route::get('/', usesas($ctrl, 'index'));
	    Route::post('/', usesas($ctrl, 'index'));
	    Route::get('agregar', usesas($ctrl, 'create'));
	    Route::post('agregar', usesas($ctrl, 'store'));
	    Route::get('ticket/{ingress}', usesas($ctrl, 'ticket'));
	    Route::get('cancelar/{ingress}/{reasons}', usesas($ctrl, 'destroy'));
	    Route::get('{ingress}', usesas($ctrl, 'show'));
	});

	Route::group(['prefix' => 'tareas', 'as' => 'task.'], function () {
	    $ctrl = 'Mailboxes\TaskController';
	    Route::get('agregar', usesas($ctrl, 'create'));
	    Route::post('agregar', usesas($ctrl, 'store'));
	    Route::get('editar', usesas($ctrl, 'edit'));
	    Route::post('editar/{task}/{thisDate?}', usesas($ctrl, 'update'));
	    Route::get('estado/{task}/{status}/{thisDate?}', usesas($ctrl, 'change'));
	    Route::get('/{thisDate?}', usesas($ctrl, 'index'));
	    Route::post('/{thisDate?}', usesas($ctrl, 'index'));
	});

	Route::group(['prefix' => 'facturas', 'as' => 'invoice.'], function () {
	    $ctrl = 'Mailboxes\InvoiceController';
	    Route::post('agregar', usesas($ctrl, 'create'));
	    Route::post('xml/{ingress}', usesas($ctrl, 'update'));
	    Route::post('complemento', usesas($ctrl, 'complement'));
	    Route::get('imprimir/{date}', usesas($ctrl, 'print'));
	    Route::get('pendientes', usesas($ctrl, 'pending'));
	    Route::get('/{thisDate?}', usesas($ctrl, 'index'));
	    Route::post('/{thisDate?}', usesas($ctrl, 'index'));
	});

	Route::group(['prefix' => 'ordenes', 'as' => 'order.'], function () {
	    $ctrl = 'Mailboxes\OrderController';
	    Route::post('/', usesas($ctrl, 'index'));
	    Route::get('/', usesas($ctrl, 'index'));
	    Route::get('{client}', usesas($ctrl, 'show'));
	    Route::post('agregar-factura', usesas($ctrl, 'update'));
	});

});