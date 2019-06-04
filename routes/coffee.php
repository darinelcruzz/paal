<?php

Route::group(['prefix' => 'coffee', 'as' => 'coffee.'], function () {

	Route::get('/', usesas('Coffee\HomeController', 'index'));

	Route::group(['prefix' => 'egresos', 'as' => 'egress.'], function () {
	    $ctrl = 'Coffee\EgressController';
	    Route::get('/', usesas($ctrl, 'index'));
	    Route::get('agregar', usesas($ctrl, 'create'));
	    Route::post('agregar', usesas($ctrl, 'store'));
	    Route::get('pagar/{egress}', usesas($ctrl, 'pay'));
	    Route::get('reemplazar/{egress}', usesas($ctrl, 'replace'));
	    Route::post('reemplazar/{egress}', usesas($ctrl, 'upload'));
	    Route::get('editar/{egress}', usesas($ctrl, 'edit'));
	    Route::post('editar/{egress}', usesas($ctrl, 'update'));
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
	    Route::post('facturar', usesas($ctrl, 'invoice'));
		Route::get('ticket/{ingress}', usesas($ctrl, 'ticket'));
		Route::get('pagos/referencias', usesas($ctrl, 'references'));
		Route::get('pagos/{ingress}', usesas($ctrl, 'payments'));
		Route::get('cancelar/{ingress}/{reasons}', usesas($ctrl, 'destroy'));
		Route::get('{ingress}', usesas($ctrl, 'show'));
	});

	Route::group(['prefix' => 'cotizaciones', 'as' => 'quotation.'], function () {
	    $ctrl = 'Coffee\QuotationController';
	    Route::get('/', usesas($ctrl, 'index'));
	    Route::post('/', usesas($ctrl, 'index'));
	    Route::get('agregar/{type}', usesas($ctrl, 'create'));
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
	    Route::match(['get', 'post'], 'diario', usesas($ctrl, 'index'));
	    Route::match(['get', 'post'], 'mensual', usesas($ctrl, 'monthly'));
	    Route::match(['get', 'post'], 'facturas', usesas($ctrl, 'invoices'));
	    Route::post('referencia', usesas($ctrl, 'reference'));
	    Route::get('excel/{date}', usesas($ctrl, 'downloadExcel'));
	    Route::get('depositos/{date}', usesas($ctrl, 'printDeposits'));
	});

	Route::group(['prefix' => 'envios', 'as' => 'shipping.'], function () {
	    $ctrl = 'Coffee\ShippingController';
	    Route::get('/', usesas($ctrl, 'index'));
	    Route::get('editar/{shipping}/{status}', usesas($ctrl, 'edit'));
	    Route::post('editar/{shipping}', usesas($ctrl, 'update'));
	    Route::get('imprimir/{shipping}', usesas($ctrl, 'print'));
	});

	Route::group(['prefix' => 'variables', 'as' => 'variable.'], function () {
	    $ctrl = 'Coffee\VariableController';
	    Route::get('/', usesas($ctrl, 'index'));
	    Route::get('editar', usesas($ctrl, 'edit'));
	    Route::post('editar/{variable}', usesas($ctrl, 'update'));
	});
});
