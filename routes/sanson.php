<?php

Route::group(['prefix' => 'sanson', 'as' => 'sanson.'], function () {

	Route::get('/', usesas('Sanson\HomeController', 'index'));

	Route::group(['prefix' => 'egresos', 'as' => 'egress.'], function () {

	    Route::group(['prefix' => 'general', 'as' => 'general.'], function () {
		    $ctrl = 'Sanson\GeneralEgressController';
		    Route::get('agregar', usesas($ctrl, 'create'));
		    Route::post('agregar', usesas($ctrl, 'store'));
		});

		Route::group(['prefix' => 'reposiciones', 'as' => 'return.'], function () {
		    $ctrl = 'Sanson\ReturnsController';
		    Route::get('agregar', usesas($ctrl, 'create'));
		    Route::post('agregar', usesas($ctrl, 'store'));
		    Route::get('gasto-extra', usesas($ctrl, 'make'));
		    Route::post('gasto-extra', usesas($ctrl, 'save'));
		});

		Route::group(['prefix' => 'caja-chica', 'as' => 'register.'], function () {
		    $ctrl = 'Sanson\CashRegisterController';
		    Route::get('/cheques', usesas($ctrl, 'index'));
		    Route::get('agregar/{check}', usesas($ctrl, 'create'));
		    Route::post('agregar/{check}', usesas($ctrl, 'store'));
		});
	    
	    $ctrl = 'Sanson\EgressController';
	    Route::get('pagar/{egress}', usesas($ctrl, 'pay'));
	    Route::post('pagar/{egress}', usesas($ctrl, 'charge'));
	    Route::get('reemplazar/{egress}', usesas($ctrl, 'replace'));
	    Route::post('reemplazar/{egress}', usesas($ctrl, 'upload'));
	    Route::get('editar/{egress}', usesas($ctrl, 'edit'));
	    Route::post('editar/{egress}', usesas($ctrl, 'update'));
	    Route::get('pdf-factura/{egress}/{column}', usesas($ctrl, 'displayPDF'));
	    Route::get('/{status}/{date?}', usesas($ctrl, 'index'));
	    Route::post('/{status}/{date?}', usesas($ctrl, 'index'));
	});

	Route::group(['prefix' => 'cheques', 'as' => 'check.'], function () {
	    $ctrl = 'Sanson\CheckController';
	    Route::get('agregar', usesas($ctrl, 'create'));
	    Route::post('agregar', usesas($ctrl, 'store'));
	    Route::get('editar/{check}', usesas($ctrl, 'edit'));
	    Route::post('editar/{check}', usesas($ctrl, 'update'));
	    Route::get('{check}', usesas($ctrl, 'show'));
	});

	Route::group(['prefix' => 'ingresos', 'as' => 'ingress.'], function () {
	    $ctrl = 'Sanson\IngressController';
	    Route::get('/', usesas($ctrl, 'index'));
	    Route::post('/', usesas($ctrl, 'index'));
	    Route::get('agregar/{type}', usesas($ctrl, 'create'));
	    Route::post('agregar', usesas($ctrl, 'store'));
		Route::get('ticket/{ingress}', usesas($ctrl, 'ticket'));
		Route::get('numeros-de-serie/{ingress}', usesas($ctrl, 'update'));
		Route::get('cancelar/{ingress}/{reasons}', usesas($ctrl, 'destroy'));
		Route::get('{ingress}', usesas($ctrl, 'show'));
	});

	Route::group(['prefix' => 'anticipos', 'as' => 'retainer.'], function () {
	    $ctrl = 'Sanson\RetainerController';
	    Route::get('agregar/{quotation}', usesas($ctrl, 'create'));
	    Route::post('agregar/{quotation}', usesas($ctrl, 'store'));
	});

	Route::group(['prefix' => 'pagos', 'as' => 'payment.'], function () {
	    $ctrl = 'Sanson\PaymentController';
	    Route::get('agregar/{ingress}', usesas($ctrl, 'create'));
	    Route::post('agregar/{ingress}', usesas($ctrl, 'store'));
	    Route::get('editar/{ingress}', usesas($ctrl, 'edit'));
	    Route::post('editar/{payment}', usesas($ctrl, 'update'));
	    Route::get('{ingress}', usesas($ctrl, 'print'));
	});

	Route::group(['prefix' => 'ediciones', 'as' => 'log.'], function () {
	    $ctrl = 'LogController';
	    Route::get('/', usesas($ctrl, 'index'));
	});

	Route::group(['prefix' => 'facturas', 'as' => 'invoice.'], function () {
	    $ctrl = 'Sanson\InvoiceController';
	    Route::post('agregar', usesas($ctrl, 'create'));
	});

	Route::group(['prefix' => 'cotizaciones', 'as' => 'quotation.'], function () {
	    $ctrl = 'Sanson\QuotationController';
	    Route::get('agregar/{type}', usesas($ctrl, 'create'));
	    Route::post('agregar', usesas($ctrl, 'store'));
	    Route::get('editar/{quotation}', usesas($ctrl, 'edit'));
	    Route::post('editar/{quotation}', usesas($ctrl, 'update'));
		Route::get('descargar/{quotation}', usesas($ctrl, 'download'));
		Route::get('imprimir/{quotation}', usesas($ctrl, 'print'));
		Route::get('transformar/{quotation}/{type?}', usesas($ctrl, 'transform'));
		Route::get('ver/{quotation}', usesas($ctrl, 'show'));
		Route::get('/{type?}', usesas($ctrl, 'index'));
	    Route::post('/{type?}', usesas($ctrl, 'index'));
	});

	Route::group(['prefix' => 'ordenes-de-compra', 'as' => 'order.'], function () {
	    $ctrl = 'Sanson\OrderController';
	    Route::get('/', usesas($ctrl, 'index'));
	    Route::post('/', usesas($ctrl, 'index'));
	    Route::get('agregar', usesas($ctrl, 'create'));
	    Route::post('agregar', usesas($ctrl, 'store'));
	    Route::get('editar/{order}', usesas($ctrl, 'edit'));
	    Route::post('editar/{order}', usesas($ctrl, 'update'));
		Route::get('imprimir/{order}', usesas($ctrl, 'print'));
		Route::get('transformar/{order}', usesas($ctrl, 'transform'));
		Route::get('{order}', usesas($ctrl, 'show'));
	});

	Route::group(['prefix' => 'compras', 'as' => 'purchase.'], function () {
	    $ctrl = 'Sanson\PurchaseController';
	    Route::get('/', usesas($ctrl, 'index'));
	    Route::post('/', usesas($ctrl, 'index'));
	    Route::get('agregar', usesas($ctrl, 'create'));
	    Route::post('agregar', usesas($ctrl, 'store'));
	    Route::get('editar/{purchase}', usesas($ctrl, 'edit'));
	    Route::post('editar/{purchase}', usesas($ctrl, 'update'));
		Route::get('imprimir/{purchase}', usesas($ctrl, 'print'));
		Route::get('{purchase}', usesas($ctrl, 'show'));
	});

	Route::group(['prefix' => 'clientes', 'as' => 'client.'], function () {
	    $ctrl = 'Sanson\ClientController';
	    Route::get('/', usesas($ctrl, 'index'));
	    Route::get('agregar', usesas($ctrl, 'create'));
	    Route::post('agregar', usesas($ctrl, 'store'));
	    Route::get('editar/{client}', usesas($ctrl, 'edit'));
	    Route::post('editar/{client}', usesas($ctrl, 'update'));
	    Route::get('{client}/{model?}', usesas($ctrl, 'show'));
	    Route::post('{client}/{model?}', usesas($ctrl, 'show'));
	});

	Route::group(['prefix' => 'productos', 'as' => 'product.'], function () {
	    $ctrl = 'Sanson\ProductController';
	    Route::get('/', usesas($ctrl, 'index'));
	    Route::get('agregar', usesas($ctrl, 'create'));
	    Route::post('agregar', usesas($ctrl, 'store'));
	    Route::get('editar/{product}', usesas($ctrl, 'edit'));
	    Route::get('serializar/{product}', usesas($ctrl, 'serialize'));
	    Route::post('editar/{product}', usesas($ctrl, 'update'));
	    Route::post('{product}', usesas($ctrl, 'show'));
	});

	Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
	    $ctrl = 'Sanson\AdminController';
	    Route::match(['get', 'post'], 'diario/{status}/{thisDate?}', usesas($ctrl, 'daily'));
	    Route::match(['get', 'post'], 'mensual', usesas($ctrl, 'monthly'));
	    Route::match(['get', 'post'], 'facturas/{thisDate?}', usesas($ctrl, 'invoices'));
	    Route::post('referencia', usesas($ctrl, 'reference'));
	    Route::get('excel/{date}', usesas($ctrl, 'downloadExcel'));
	    Route::get('depositos/{date}', usesas($ctrl, 'printDeposits'));
	});

	Route::group(['prefix' => 'envios', 'as' => 'shipping.'], function () {
	    $ctrl = 'Sanson\ShippingController';
	    Route::get('mensual', usesas($ctrl, 'monthly'));
	    Route::post('mensual', usesas($ctrl, 'monthly'));
	    Route::get('numero-guia/{shipping}', usesas($ctrl, 'addInfo'));
	    Route::get('editar/{shipping}', usesas($ctrl, 'edit'));
	    Route::post('editar/{shipping}', usesas($ctrl, 'update'));
	    Route::get('imprimir/{shipping}', usesas($ctrl, 'print'));
	    Route::get('/{status}', usesas($ctrl, 'index'));
	    Route::post('/{status}', usesas($ctrl, 'index'));
	});

	Route::group(['prefix' => 'variables', 'as' => 'variable.'], function () {
	    $ctrl = 'Sanson\VariableController';
	    Route::get('/', usesas($ctrl, 'index'));
	    Route::get('editar', usesas($ctrl, 'edit'));
	    Route::post('editar/{variable}', usesas($ctrl, 'update'));
	});

	Route::group(['prefix' => 'tareas', 'as' => 'task.'], function () {
	    $ctrl = 'Sanson\TaskController';
	    Route::get('agregar', usesas($ctrl, 'create'));
	    Route::post('agregar', usesas($ctrl, 'store'));
	    Route::get('editar', usesas($ctrl, 'edit'));
	    Route::post('editar/{task}/{thisDate?}', usesas($ctrl, 'update'));
	    Route::get('estado/{task}/{status}/{thisDate?}', usesas($ctrl, 'change'));
	    Route::get('/{thisDate?}', usesas($ctrl, 'index'));
	    Route::post('/{thisDate?}', usesas($ctrl, 'index'));
	});

	Route::group(['prefix' => 'direcciones', 'as' => 'address.'], function () {
	    $ctrl = 'Sanson\AddressController';
	    Route::get('/', usesas($ctrl, 'index'));
	    Route::get('agregar/{client}', usesas($ctrl, 'create'));
	    Route::post('agregar/{client}', usesas($ctrl, 'store'));
	    Route::get('editar/{address}', usesas($ctrl, 'edit'));
	    Route::post('editar/{address}', usesas($ctrl, 'update'));
	});

	Route::group(['prefix' => 'numeros-de-serie', 'as' => 'serial_number.'], function () {
	    $ctrl = 'Sanson\SerialNumberController';
	    Route::get('/', usesas($ctrl, 'index'));
	    Route::get('agregar', usesas($ctrl, 'create'));
	    Route::post('agregar', usesas($ctrl, 'store'));
	    Route::get('editar/{serial_number}', usesas($ctrl, 'edit'));
	    Route::post('editar/{ingress}', usesas($ctrl, 'update'));
	});
});
