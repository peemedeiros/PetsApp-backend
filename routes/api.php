<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->namespace('Api')->group(function (){

    Route::post('users', 'UserController@store')->name('registrar');

    Route::post('login', 'Auth\\LoginJwtController@login')->name('login');
    Route::get('logout', 'Auth\\LoginJwtController@logout')->name('logout');
    Route::get('refresh', 'Auth\\LoginJwtController@refresh')->name('refresh');
    Route::get('empresas-cadastradas', 'EmpresaController@all')->name('empresas-cadastradas');

    Route::group(['middleware' => ['jwt.auth']], function (){

        Route::name('users.')->group(function () {
            Route::resource('users', 'UserController')->only([
                'index','show','update', 'destroy'
            ]);
        });
//
        //Rotas empresas
        Route::name('empresas.')->group(function () {
            Route::resource('empresas', 'EmpresaController');
        });
    });
});
