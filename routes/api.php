<?php

use Illuminate\Http\Request;

Route::group(['prefix' => 'products', 'as' => 'api.product.'], function () {
    $ctrl = 'Api\ProductController';
    Route::get('seriable/{company}/{keyword?}', usesas($ctrl, 'seriable'));
    Route::get('mbe/{keyword?}', usesas($ctrl, 'mbe'));
    Route::get('sanson/{keyword?}', usesas($ctrl, 'sanson'));
    Route::get('coffee/{keyword?}', usesas($ctrl, 'coffee'));
    Route::get('amount/{date}/{category?}', usesas($ctrl, 'amount'));
    Route::get('{product}', usesas($ctrl, 'show'));
});

Route::group(['prefix' => 'clients', 'as' => 'api.client.'], function () {
	$ctrl = 'Api\ClientController';
    Route::get('/{client}/addresses', usesas($ctrl, 'addresses'));
    Route::get('draw/{type}/{date}', usesas($ctrl, 'draw'));
	Route::get('/{company}', usesas($ctrl, 'index'));
});

Route::group(['prefix' => 'providers', 'as' => 'api.provider.'], function () {
    $ctrl = 'Api\ProviderController';
    Route::get('{company}/{group}', usesas($ctrl, 'index'));
});

Route::group(['prefix' => 'states', 'as' => 'api.state.'], function () {
    $ctrl = 'Api\StateController';
    Route::get('/', usesas($ctrl, 'index'));
    Route::get('{state}', usesas($ctrl, 'show'));
    Route::get('{state}/counties', usesas($ctrl, 'counties'));
});

Route::group(['prefix' => 'counties', 'as' => 'api.county.'], function () {
    $ctrl = 'Api\CountyController';
    Route::get('{county}/cities', usesas($ctrl, 'cities'));
});

Route::group(['prefix' => 'sales', 'as' => 'api.sale.'], function () {
	$ctrl = 'Api\SaleController';
	Route::get('show/{ingress}', usesas($ctrl, 'show'));
});

Route::group(['prefix' => 'quotations', 'as' => 'api.quotation.'], function () {
    $ctrl = 'Api\QuotationController';
    Route::get('{quotation}/movements', usesas($ctrl, 'movements'));
});

Route::group(['prefix' => 'notifications', 'as' => 'api.notification.'], function () {
    $ctrl = 'Api\NotificationController';
    Route::get('{company}/shippings', usesas($ctrl, 'shippings'));
    Route::get('{company}/egresses', usesas($ctrl, 'egresses'));
    Route::get('{company}/numbers', usesas($ctrl, 'numbers'));
    Route::get('{company}/tasks', usesas($ctrl, 'tasks'));
    Route::get('{company}/expired', usesas($ctrl, 'expired'));
});

Route::group(['prefix' => 'monthly', 'as' => 'api.ingress.'], function () {
    $ctrl = 'Api\IngressController';
    Route::get('ingresses/{date?}/{company?}/{type?}', usesas($ctrl, 'ingresses'));
    Route::get('payments/{date?}/{company?}/{method?}', usesas($ctrl, 'payments'));
    Route::get('index/{date?}/{company?}/{type?}', usesas($ctrl, 'index'));
    Route::get('table/{type?}', usesas($ctrl, 'table'));
});

Route::group(['prefix' => 'movements', 'as' => 'api.movement.'], function () {
    $ctrl = 'Api\MovementController';
    Route::get('{type}/{id}', usesas($ctrl, 'index'));
});

Route::group(['prefix' => 'payments', 'as' => 'api.payment.'], function () {
    $ctrl = 'Api\PaymentController';
    Route::get('{id}', usesas($ctrl, 'index'));
});
