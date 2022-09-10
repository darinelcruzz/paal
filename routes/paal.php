<?php

Route::group(['prefix' => 'paal', 'as' => 'paal.'], function () {

	Route::get('/', usesas('Paal\HomeController', 'index'));

	Route::group(['prefix' => 'ediciones', 'as' => 'log.'], function () {
	    $ctrl = 'LogController';
	    Route::get('/', usesas($ctrl, 'index'));
	});

	Route::group(['prefix' => 'proveedores', 'as' => 'provider.'], function () {
	    $ctrl = 'ProviderController';
	    Route::get('/', usesas($ctrl, 'index'));
	    Route::get('agregar', usesas($ctrl, 'create'));
	    Route::post('agregar', usesas($ctrl, 'store'));
		Route::get('editar/{provider}', usesas($ctrl, 'edit'));
	    Route::post('editar/{provider}', usesas($ctrl, 'update'));
	    Route::get('cancelar/{provider}', usesas($ctrl, 'destroy'));
	    Route::get('{provider}', usesas($ctrl, 'show'));
	    Route::post('{provider}', usesas($ctrl, 'show'));
	});

	Route::group(['prefix' => 'flujos-financieros', 'as' => 'financial-flow.'], function () {
	    $ctrl = 'FinancialFlowController';
	    Route::get('iva', usesas($ctrl, 'iva'));
	    Route::get('subtotal', usesas($ctrl, 'subtotal'));
	});

	Route::group(['prefix' => 'egresos', 'as' => 'egress.'], function () {

		Route::group(['prefix' => 'caja-chica', 'as' => 'register.'], function () {
		    $ctrl = 'Paal\CashRegisterController';
		    Route::get('agregar/{check}', usesas($ctrl, 'create'));
		    Route::post('agregar/{check}', usesas($ctrl, 'store'));
		    Route::get('/cheques', usesas($ctrl, 'index'));
		});
	    
	    $ctrl = 'Paal\EgressController';
	    Route::get('agregar', usesas($ctrl, 'create'));
		Route::post('agregar', usesas($ctrl, 'store'));
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

	Route::group(['prefix' => 'cheques', 'as' => 'check.'], function () {
	    $ctrl = 'Paal\CheckController';
	    Route::get('agregar', usesas($ctrl, 'create'));
	    Route::post('agregar', usesas($ctrl, 'store'));
	    Route::get('editar/{check}', usesas($ctrl, 'edit'));
	    Route::post('editar/{check}', usesas($ctrl, 'update'));
	    Route::get('{check}', usesas($ctrl, 'show'));
	});

	Route::group(['prefix' => 'ingresos', 'as' => 'ingress.'], function () {
	    $ctrl = 'Paal\AdminController';
	    Route::get('mensual/{company}', usesas($ctrl, 'monthly'));
	    Route::post('mensual/{company}', usesas($ctrl, 'monthly'));
	    Route::match(['get', 'post'], 'diario/{company}/{status}/{thisDate?}', usesas($ctrl, 'daily'));
	    Route::post('por-paqueteria', usesas($ctrl, 'companies'));
	});

	Route::group(['prefix' => 'ingresos', 'as' => 'ingress.'], function () {
	    $ctrl = 'IngressController';
	    Route::get('/{thisDate?}', usesas($ctrl, 'index'));
	    Route::post('/', usesas($ctrl, 'index'));
	});

	Route::group(['prefix' => 'productos', 'as' => 'product.'], function () {
	    $ctrl = 'ProductController';
	    Route::get('agregar', usesas($ctrl, 'create'));
	    Route::get('agregar-mbe', usesas($ctrl, 'add'));
	    Route::post('agregar', usesas($ctrl, 'store'));
	    Route::get('editar/{product}', usesas($ctrl, 'edit'));
	    Route::post('editar/{product}', usesas($ctrl, 'update'));
	    Route::get('axios/{product}', usesas($ctrl, 'axios'));
	    Route::get('{company?}', usesas($ctrl, 'index'));
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

	Route::group(['prefix' => 'estados', 'as' => 'state.', 'middleware' => 'admin'], function () {
	    $ctrl = 'StateController';
	    Route::get('/', usesas($ctrl, 'index'));
	    Route::get('agregar', usesas($ctrl, 'create'));
	    Route::post('agregar', usesas($ctrl, 'store'));
	    Route::get('editar/{state}', usesas($ctrl, 'edit'));
	    Route::post('editar/{state}', usesas($ctrl, 'update'));
	});

	Route::group(['prefix' => 'variables', 'as' => 'variable.', 'middleware' => 'admin'], function () {
	    $ctrl = 'Paal\VariableController';
	    Route::get('/', usesas($ctrl, 'index'));
	    Route::get('editar/{variable}', usesas($ctrl, 'edit'));
	    Route::post('editar/{variable}', usesas($ctrl, 'update'));
	});

	Route::group(['prefix' => 'ediciones', 'as' => 'log.'], function () {
	    $ctrl = 'LogController';
	    Route::get('/', usesas($ctrl, 'index'));
	});

	Route::get('tipo_de_cambio', function ()
	{
		return view('auth.exchange');
	})->name('exchange.index');

	Route::post('tipo_de_cambio', function ()
	{
		updateEnv('EXCHANGE_RATE', request()->exchange_rate);

		return redirect(route('paal.exchange.index'));
		
	})->name('exchange.update');
});
