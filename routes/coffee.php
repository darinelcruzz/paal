<?php

Route::get('/cambiar-tienda/{store}', function ($store) {
    $user = App\User::find(auth()->user()->id);
    $user->update(['store_id' => $store]);
    return redirect(route('coffee.index'));
});

Route::group(['prefix' => 'cocinaspaal', 'as' => 'coffee.'], function () {

	Route::get('/', usesas('Coffee\HomeController', 'index'));
	Route::get('/cambiar-tienda/{store?}', usesas('Coffee\HomeController', 'index'));

	Route::get('get-methods', function () {
		$ingresses = App\Ingress::whereCompany('coffee')->get();

		$methods = ['undefined' => null, 'cash' => 'efectivo', 'transfer' => 'transferencia', 'check' => 'cheque', 'debit_card' => 'tarjeta débito', 'credit_card' => 'tarjeta crédito'];

		foreach ($ingresses as $ingress) {
			$ingress->update(['method' => $methods[$ingress->method]]);
		}

		return 'LISTO';
	});

	Route::group(['prefix' => 'egresos', 'as' => 'egress.'], function () {

	    Route::group(['prefix' => 'general', 'as' => 'general.'], function () {
		    $ctrl = 'Coffee\GeneralEgressController';
		    Route::get('agregar', usesas($ctrl, 'create'));
		    Route::post('agregar', usesas($ctrl, 'store'));
		});

		Route::group(['prefix' => 'reposiciones', 'as' => 'return.'], function () {
		    $ctrl = 'Coffee\ReturnsController';
		    Route::get('agregar', usesas($ctrl, 'create'));
		    Route::post('agregar', usesas($ctrl, 'store'));
		    Route::get('gasto-extra', usesas($ctrl, 'make'));
		    Route::post('gasto-extra', usesas($ctrl, 'save'));
		});

		Route::group(['prefix' => 'caja-chica', 'as' => 'register.'], function () {
		    $ctrl = 'Coffee\CashRegisterController';
		    Route::get('/cheques', usesas($ctrl, 'index'));
		    Route::get('agregar/{check}', usesas($ctrl, 'create'));
		    Route::post('agregar/{check}', usesas($ctrl, 'store'));
		});
	    
	    $ctrl = 'Coffee\EgressController';
	    Route::get('pagar/{egress}', usesas($ctrl, 'pay'));
	    Route::post('pagar/{egress}', usesas($ctrl, 'charge'));
	    Route::get('reemplazar/{egress}', usesas($ctrl, 'replace'));
	    Route::post('reemplazar/{egress}', usesas($ctrl, 'upload'));
	    Route::get('editar/{egress}', usesas($ctrl, 'edit'));
	    Route::get('eliminar/{egress}', usesas($ctrl, 'destroy'));
	    Route::post('editar/{egress}', usesas($ctrl, 'update'));
	    Route::get('pdf-factura/{egress}/{column}', usesas($ctrl, 'displayPDF'));
	    Route::get('/{status?}/{date?}', usesas($ctrl, 'index'));
	    Route::post('/{status?}/{date?}', usesas($ctrl, 'index'));
	});

	Route::group(['prefix' => 'ingresos', 'as' => 'ingress.'], function () {
	    $ctrl = 'Coffee\IngressController';
	    Route::get('/', usesas($ctrl, 'index'));
	    Route::post('/', usesas($ctrl, 'index'));
	    Route::get('agregar/{type?}', usesas($ctrl, 'create'));
	    Route::post('agregar', usesas($ctrl, 'store'));
	    Route::get('numeros-de-serie/{ingress}', usesas($ctrl, 'update'));
	    Route::post('agregar-sae/{ingress}', usesas($ctrl, 'updateSAE'));
		Route::get('ticket/{ingress}', usesas($ctrl, 'ticket'));
		Route::get('cancelar/{ingress}/{reasons}', usesas($ctrl, 'destroy'));
		Route::get('{ingress}', usesas($ctrl, 'show'));
	});

	Route::group(['prefix' => 'anticipos', 'as' => 'retainer.'], function () {
	    $ctrl = 'Coffee\RetainerController';
	    Route::get('agregar/{quotation}', usesas($ctrl, 'create'));
	    Route::post('agregar/{quotation}', usesas($ctrl, 'store'));
	});

	Route::group(['prefix' => 'pagos', 'as' => 'payment.'], function () {
	    $ctrl = 'Coffee\PaymentController';
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
	    $ctrl = 'Coffee\InvoiceController';
	    Route::post('agregar', usesas($ctrl, 'create'));
	});

	Route::group(['prefix' => 'cotizaciones', 'as' => 'quotation.'], function () {
	    $ctrl = 'Coffee\QuotationController';
	    Route::get('agregar/{type?}', usesas($ctrl, 'create'));
	    Route::post('agregar', usesas($ctrl, 'store'));
	    Route::get('editar/{quotation}', usesas($ctrl, 'edit'));
	    Route::post('editar/{quotation}', usesas($ctrl, 'update'));
		Route::get('imprimir/{quotation}', usesas($ctrl, 'print'));
		Route::get('descargar/{quotation}', usesas($ctrl, 'download'));
		Route::get('mover/{quotation}', usesas($ctrl, 'move'));
		Route::get('transformar/{quotation}', usesas($ctrl, 'transform'));
		Route::get('hacer-venta/{quotation}', usesas($ctrl, 'alter'));
		Route::get('ver/{quotation}', usesas($ctrl, 'show'));
	    Route::get('/{status}/{type?}', usesas($ctrl, 'index'));
	    Route::post('/{status}/{type?}', usesas($ctrl, 'index'));
	});

	Route::group(['prefix' => 'clientes', 'as' => 'client.'], function () {
	    $ctrl = 'Coffee\ClientController';
	    Route::get('/', usesas($ctrl, 'index'));
	    Route::get('agregar', usesas($ctrl, 'create'));
	    Route::post('agregar', usesas($ctrl, 'store'));
	    Route::get('exportar', usesas($ctrl, 'export'));
	    Route::post('importar', usesas($ctrl, 'import'));
	    Route::get('editar/{client}', usesas($ctrl, 'edit'));
	    Route::post('editar/{client}', usesas($ctrl, 'update'));
	    Route::get('{client}/{model?}', usesas($ctrl, 'show'));
	    Route::post('{client}/{model?}', usesas($ctrl, 'show'));
	});

	Route::group(['prefix' => 'productos', 'as' => 'product.'], function () {
	    $ctrl = 'Coffee\ProductController';
	    Route::get('/', usesas($ctrl, 'index'));
	    Route::get('agregar', usesas($ctrl, 'create'));
	    Route::post('agregar', usesas($ctrl, 'store'));
	    Route::get('exportar/{company?}', usesas($ctrl, 'export'));
	    Route::get('editar/{product}', usesas($ctrl, 'edit'));
	    Route::get('serializar/{product}', usesas($ctrl, 'serialize'));
	    Route::post('editar/{product}', usesas($ctrl, 'update'));
	    Route::post('importar', usesas($ctrl, 'import'));
	    Route::group(['prefix' => 'pure-mix', 'as' => 'puremix.'], function () {
	    	$ctrl = 'Coffee\PureMixController';
	    	Route::get('/', usesas($ctrl, 'index'));
	    	Route::post('agregar', usesas($ctrl, 'store'));
	    	Route::post('buscar', usesas($ctrl, 'search'));
	    });
	});

	Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
	    $ctrl = 'Coffee\AdminController';
	    Route::match(['get', 'post'], 'diario/{status}/{thisDate?}', usesas($ctrl, 'daily'));
	    Route::match(['get', 'post'], 'mensual', usesas($ctrl, 'monthly'));
	    Route::match(['get', 'post'], 'facturas/{thisDate?}', usesas($ctrl, 'invoices'));
	    Route::post('referencia', usesas($ctrl, 'reference'));
	    Route::get('excel/{date}', usesas($ctrl, 'downloadExcel'));
	    Route::get('depositos/{date}', usesas($ctrl, 'printDeposits'));
	});

	Route::group(['prefix' => 'envios', 'as' => 'shipping.'], function () {
	    $ctrl = 'Coffee\ShippingController';
	    Route::get('mensual', usesas($ctrl, 'monthly'));
	    Route::post('mensual', usesas($ctrl, 'monthly'));
	    Route::get('numero-guia/{shipping}', usesas($ctrl, 'addInfo'));
	    Route::get('editar/{shipping}', usesas($ctrl, 'edit'));
	    Route::post('editar/{shipping}', usesas($ctrl, 'update'));
	    Route::get('imprimir/{shipping}', usesas($ctrl, 'print'));
	    Route::get('/{status}', usesas($ctrl, 'index'));
	    Route::post('/{status}', usesas($ctrl, 'index'));
	});

	Route::group(['prefix' => 'ordenes-de-compra', 'as' => 'order.'], function () {
	    $ctrl = 'Coffee\OrderController';
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
	    $ctrl = 'Coffee\PurchaseController';
	    Route::get('/', usesas($ctrl, 'index'));
	    Route::post('/', usesas($ctrl, 'index'));
	    Route::get('agregar', usesas($ctrl, 'create'));
	    Route::post('agregar', usesas($ctrl, 'store'));
	    Route::get('editar/{purchase}', usesas($ctrl, 'edit'));
	    Route::post('editar/{purchase}', usesas($ctrl, 'update'));
		Route::get('imprimir/{purchase}', usesas($ctrl, 'print'));
		Route::get('{purchase}', usesas($ctrl, 'show'));
	});

	Route::group(['prefix' => 'variables', 'as' => 'variable.'], function () {
	    $ctrl = 'Coffee\VariableController';
	    Route::get('/', usesas($ctrl, 'index'));
	    Route::get('editar', usesas($ctrl, 'edit'));
	    Route::post('editar/{variable}', usesas($ctrl, 'update'));
	});

	Route::group(['prefix' => 'tareas', 'as' => 'task.'], function () {
	    $ctrl = 'Coffee\TaskController';
	    Route::get('agregar', usesas($ctrl, 'create'));
	    Route::post('agregar', usesas($ctrl, 'store'));
	    Route::get('editar/{task}', usesas($ctrl, 'edit'));
	    Route::post('editar/{task}', usesas($ctrl, 'update'));
	    Route::post('terminar/{task}/{thisDate?}', usesas($ctrl, 'complete'));
	    Route::get('estado/{task}/{status}/{thisDate?}', usesas($ctrl, 'change'));
	    Route::get('/{thisDate?}', usesas($ctrl, 'index'));
	    Route::post('/{thisDate?}', usesas($ctrl, 'index'));
	});

	Route::group(['prefix' => 'direcciones', 'as' => 'address.'], function () {
	    $ctrl = 'Coffee\AddressController';
	    Route::get('/', usesas($ctrl, 'index'));
	    Route::get('agregar/{client}', usesas($ctrl, 'create'));
	    Route::post('agregar/{client}', usesas($ctrl, 'store'));
	    Route::get('editar/{address}', usesas($ctrl, 'edit'));
	    Route::post('editar/{address}', usesas($ctrl, 'update'));
	});

	Route::group(['prefix' => 'numeros-de-serie', 'as' => 'serial_number.'], function () {
	    $ctrl = 'Coffee\SerialNumberController';
	    Route::get('/', usesas($ctrl, 'index'));
	    Route::get('agregar', usesas($ctrl, 'create'));
	    Route::post('agregar', usesas($ctrl, 'store'));
	    Route::post('dar-salida/{serial_number}', usesas($ctrl, 'release'));
	    Route::get('editar/{serial_number}', usesas($ctrl, 'edit'));
	    Route::post('editar/{ingress}', usesas($ctrl, 'update'));
	});

	Route::group(['prefix' => 'estadisticas', 'as' => 'statistics.'], function () {
	    $ctrl = 'Coffee\StatisticsController';
	    Route::get('ventas/{category?}/{date?}', usesas($ctrl, 'sales'));
	    Route::post('ventas/{category?}/{date?}', usesas($ctrl, 'sales'));
	    Route::get('envíos/{provider?}/{date?}', usesas($ctrl, 'shippings'));
	    Route::post('envíos/{provider?}/{date?}', usesas($ctrl, 'shippings'));
	    Route::get('clientes', usesas($ctrl, 'clients'));
	    Route::post('clientes', usesas($ctrl, 'clients'));
	    Route::get('lugares', usesas($ctrl, 'places'));
	    Route::post('lugares', usesas($ctrl, 'places'));
	});

	Route::group(['prefix' => 'ventas/analisis', 'as' => 'analysis.'], function () {
	    $ctrl = 'Coffee\SalesAnalysisController';
	    Route::get('/', usesas($ctrl, 'index'));
	    Route::post('/', usesas($ctrl, 'index'));
	    Route::get('/productos/{date}', usesas($ctrl, 'show'));
	});
});
