<?php

use Illuminate\Http\Request;

Route::group(['prefix' => 'products', 'as' => 'api.product.'], function () {
    $ctrl = 'Api\ProductController';
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
