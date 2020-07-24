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

        //Rotas empresas
        Route::name('empresas.')->group(function () {
            Route::resource('empresas', 'EmpresaController');
        });

        //Rotas Categoria
        Route::name('categorias.')->group(function () {
            Route::get('categorias/{id}/empresas', 'CategoriaController@empresa');
            Route::resource('categorias', 'CategoriaController');
        });

        //Rotas Subcategorias
        Route::name('subcategorias.')->group(function () {
            Route::resource('subcategorias', 'SubcategoriaController');
        });

        //Rotas Servicos
        Route::name('servicos.')->group(function () {
            Route::get('servicos/empresa/{id}', 'ServicoController@all');
            Route::resource('servicos', 'ServicoController');
        });

        //Rotas Especies
        Route::name('especies.')->group(function(){
           Route::resource('especies', 'EspecieController');
        });

        //Rotas Animais
        Route::name('animais.')->group(function(){
            Route::get('animais/user/{id}', 'AnimalController@all');
            Route::resource('animais', 'AnimalController');
        });

        //Rotas Endereco
        Route::name('enderecos.')->group(function(){
            Route::resource('enderecos', 'EnderecoClienteController');
        });

        Route::name('agendamentos.')->group(function(){
            Route::put('agendamentos/{id}', 'AgendamentoServicoController@aceitarServico');
            Route::put('agendamentos/pagamento/{id}', 'AgendamentoServicoController@pagarAgendamento');
            Route::resource('agendamentos', 'AgendamentoServicoController');
        });

        Route::name('pagamentos')->group(function (){
            Route::resource('pagamentos', 'MetodoPagamentoController');
        });
    });
});
