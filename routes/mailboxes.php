<?php

Route::group(['prefix' => 'mbe', 'as' => 'mbe.'], function () {
	
	Route::get('/', usesas('Mailboxes\HomeController', 'index'));
});