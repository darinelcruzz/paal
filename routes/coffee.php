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
	    Route::post('/', usesas($ctrl, 'index'));
	    Route::get('agregar', usesas($ctrl, 'create'));
	    Route::post('agregar', usesas($ctrl, 'store'));
	    Route::get('pagar/{ingress}', usesas($ctrl, 'charge'));
	    Route::post('pagar/{ingress}', usesas($ctrl, 'pay'));
	    Route::post('facturar/efectivo', usesas($ctrl, 'invoices'));
	    Route::post('facturar/{ingress}', usesas($ctrl, 'invoice'));
		Route::get('ticket/{ingress}', usesas($ctrl, 'ticket'));
		Route::get('pagos/{ingress}', usesas($ctrl, 'payments'));
		Route::get('cancelar/{ingress}/{reasons}', usesas($ctrl, 'destroy'));
		Route::get('{ingress}', usesas($ctrl, 'show'));
	});

	Route::group(['prefix' => 'cotizaciones', 'as' => 'quotation.'], function () {
	    $ctrl = 'Coffee\QuotationController';
	    Route::get('/', usesas($ctrl, 'index'));
	    Route::post('/', usesas($ctrl, 'index'));
	    Route::get('agregar', usesas($ctrl, 'create'));
	    Route::post('agregar', usesas($ctrl, 'store'));
	    Route::get('editar/{quotation}', usesas($ctrl, 'edit'));
	    Route::post('editar/{quotation}', usesas($ctrl, 'update'));
		Route::get('descargar/{quotation}', usesas($ctrl, 'download'));
		Route::get('transformar/{quotation}', usesas($ctrl, 'transform'));
		Route::get('{quotation}', usesas($ctrl, 'show'));
	});

	Route::group(['prefix' => 'clientes', 'as' => 'client.'], function () {
	    $ctrl = 'Coffee\ClientController';
	    Route::get('/', usesas($ctrl, 'index'));
	    Route::get('agregar', usesas($ctrl, 'create'));
	    Route::post('agregar', usesas($ctrl, 'store'));
	    Route::get('editar/{client}', usesas($ctrl, 'edit'));
	    Route::post('editar/{client}', usesas($ctrl, 'update'));
	});

	Route::group(['prefix' => 'productos', 'as' => 'product.'], function () {
	    $ctrl = 'Coffee\ProductController';
	    Route::get('/', usesas($ctrl, 'index'));
	    Route::get('editar/{product}', usesas($ctrl, 'edit'));
	    Route::post('editar/{product}', usesas($ctrl, 'update'));
	});

	Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
	    $ctrl = 'Coffee\AdminController';
	    Route::match(['get', 'post'], '/', usesas($ctrl, 'index'));
	    Route::match(['get', 'post'], 'facturas', usesas($ctrl, 'invoices'));
	    Route::match(['get', 'post'], 'referencia', usesas($ctrl, 'reference'));
	});
});
