<?php

use Illuminate\Http\Request;

Route::group(['prefix' => 'products', 'as' => 'api.product.'], function () {
    $ctrl = 'Api\ProductController';
    Route::get('/', usesas($ctrl, 'index'));
    Route::get('/equipment', usesas($ctrl, 'equipment'));
    Route::get('{keyword}', usesas($ctrl, 'search'));
});

Route::group(['prefix' => 'equipment', 'as' => 'api.equipment.'], function () {
    $ctrl = 'Api\ProductController';
    Route::get('/', usesas($ctrl, 'equipment'));
    Route::get('{keyword}', usesas($ctrl, 'searchEquipment'));
});

Route::group(['prefix' => 'clients', 'as' => 'api.client.'], function () {
	$ctrl = 'Api\ClientController';
	Route::get('/', usesas($ctrl, 'index'));
});

Route::group(['prefix' => 'sales', 'as' => 'api.sale.'], function () {
	$ctrl = 'Api\SaleController';
	Route::get('show/{ingress}', usesas($ctrl, 'show'));
});