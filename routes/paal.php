<?php

Route::group(['prefix' => 'paal', 'as' => 'paal.'], function () {
	
	Route::get('/', usesas('Paal\HomeController', 'index'));
});