<?php

use Botble\Base\Facades\BaseHelper;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Botble\AdminAddon\Http\Controllers', 'middleware' => ['web', 'core']], function () {

    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {

        Route::group(['prefix' => 'database-translation', 'as' => 'database-translation.'], function () {
            Route::resource('', 'DatabaseTranslationController')->parameters(['' => 'database-translation']);
        });
    });

});
