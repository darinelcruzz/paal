<?php

Route::group(['prefix' => 'sanson', 'as' => 'sanson.'], function () {

	Route::get('/', usesas('Sanson\HomeController', 'index'));
	
	Route::get('/poner-empresa-a-los-productos-de-mbe', function () {
		$products = App\Product::whereCategory('MBE')->get();

		foreach ($products as $product) {
			$product->update([
				'company' => 'MBE'
			]);
		}
	});

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
		Route::get('cancelar/{ingress}/{reasons}', usesas($ctrl, 'destroy'));
		Route::get('{ingress}', usesas($ctrl, 'show'));
	});

	Route::group(['prefix' => 'pagos', 'as' => 'payment.'], function () {
	    $ctrl = 'Sanson\PaymentController';
	    Route::get('agregar/{ingress}', usesas($ctrl, 'create'));
	    Route::post('agregar/{ingress}', usesas($ctrl, 'store'));
	    Route::get('{ingress}', usesas($ctrl, 'print'));
	});

	Route::group(['prefix' => 'facturas', 'as' => 'invoice.'], function () {
	    $ctrl = 'Sanson\InvoiceController';
	    Route::post('agregar', usesas($ctrl, 'create'));
	});

	Route::group(['prefix' => 'cotizaciones', 'as' => 'quotation.'], function () {
	    $ctrl = 'Sanson\QuotationController';
	    Route::get('/', usesas($ctrl, 'index'));
	    Route::post('/', usesas($ctrl, 'index'));
	    Route::get('internet', usesas($ctrl, 'internet'));
	    Route::post('internet', usesas($ctrl, 'internet'));
	    Route::get('agregar/{type}', usesas($ctrl, 'create'));
	    Route::post('agregar', usesas($ctrl, 'store'));
	    Route::get('editar/{quotation}', usesas($ctrl, 'edit'));
	    Route::post('editar/{quotation}', usesas($ctrl, 'update'));
		Route::get('descargar/{quotation}', usesas($ctrl, 'download'));
		Route::get('transformar/{quotation}/{type?}', usesas($ctrl, 'transform'));
		Route::get('{quotation}', usesas($ctrl, 'show'));
	});

	Route::group(['prefix' => 'clientes', 'as' => 'client.'], function () {
	    $ctrl = 'Sanson\ClientController';
	    Route::get('/', usesas($ctrl, 'index'));
	    Route::get('agregar', usesas($ctrl, 'create'));
	    Route::post('agregar', usesas($ctrl, 'store'));
	    Route::get('editar/{client}', usesas($ctrl, 'edit'));
	    Route::post('editar/{client}', usesas($ctrl, 'update'));
	});

	Route::group(['prefix' => 'productos', 'as' => 'product.'], function () {
	    $ctrl = 'Sanson\ProductController';
	    Route::get('/', usesas($ctrl, 'index'));
	    Route::get('editar/{product}', usesas($ctrl, 'edit'));
	    Route::post('editar/{product}', usesas($ctrl, 'update'));
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
});
