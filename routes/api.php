<?php

use Illuminate\Http\Request;

Route::group(['prefix' => 'products', 'as' => 'api.product.'], function () {
    $ctrl = 'Api\ProductController';
    Route::get('seriable/{company}/{keyword?}', usesas($ctrl, 'seriable'));
    Route::get('mbe/{keyword?}', usesas($ctrl, 'mbe'));
    Route::get('sanson/{keyword?}', usesas($ctrl, 'sanson'));
    Route::get('coffee/{keyword?}', usesas($ctrl, 'coffee'));
    Route::get('{product}', usesas($ctrl, 'show'));
});

Route::group(['prefix' => 'clients', 'as' => 'api.client.'], function () {
	$ctrl = 'Api\ClientController';
	Route::get('/{company}', usesas($ctrl, 'index'));
});

Route::group(['prefix' => 'providers', 'as' => 'api.provider.'], function () {
    $ctrl = 'Api\ProviderController';
    Route::get('{company}/{group}', usesas($ctrl, 'index'));
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
