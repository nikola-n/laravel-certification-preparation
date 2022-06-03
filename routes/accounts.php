<?php

use Illuminate\Support\Facades\Route;


Route::get('members', 'AccountController@index')->name('members');

//Route::redirect('/here', '/there');
