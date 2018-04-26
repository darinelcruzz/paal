<?php

Route::group(['prefix' => 'mbe', 'as' => 'mbe.'], function () {
	
	Route::get('/', usesas('Mailboxes\HomeController', 'index'));

	Route::group(['prefix' => 'egresos', 'as' => 'egress.'], function () {
	    $ctrl = 'Mailboxes\EgressController';
	    Route::get('/', usesas($ctrl, 'index'));
	    Route::get('agregar', usesas($ctrl, 'create'));
	    Route::post('agregar', usesas($ctrl, 'store'));
	    Route::get('pagar/{egress}', usesas($ctrl, 'pay'));
	    Route::post('pagar', usesas($ctrl, 'settle'));
	});
});