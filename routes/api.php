<?php

use Illuminate\Http\Request;

Route::group(['prefix' => 'products', 'as' => 'api.product.'], function () {
    $ctrl = 'Api\ProductController';
    Route::get('/', usesas($ctrl, 'index'));
    Route::get('{keyword}', usesas($ctrl, 'search'));
});