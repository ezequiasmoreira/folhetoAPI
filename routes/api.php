<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', 'UserController@register');
Route::post('login', 'UserController@authenticate');
Route::get('open', 'DataController@open');

//localização
Route::group(["prefix" => "pais","namespace" => "localizacao"], function () {    
    Route::get("/{id}", "PaisController@getPais");    
});
Route::group(["prefix" => "cidade","namespace" => "localizacao"], function () {
    Route::get("/{id}", "CidadeController@getCidade");
    Route::get("/{estado_id}/estado", "CidadeController@getCidadePorEstado");
});

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('user', 'UserController@getAuthenticatedUser');
    Route::get('closed', 'DataController@closed');

    //localizacao
    Route::group(["prefix" => "pais","namespace" => "localizacao"], function () {    
        Route::delete("/{id}/excluir", "PaisController@excluir");
        Route::post("/salvar", "PaisController@salvar");
        Route::Put("/atualizar", "PaisController@atualizar");
        
    });
    Route::group(["prefix" => "estado","namespace" => "localizacao"], function () {
        Route::delete("/{id}/excluir", "EstadoController@excluir");
        Route::post("/salvar", "EstadoController@salvar");
        Route::put("/atualizar", "EstadoController@atualizar");
    });    
    Route::group(["prefix" => "cidade","namespace" => "localizacao"], function () {
        Route::delete("/{id}/excluir", "CidadeController@excluir");
        Route::post("/salvar", "CidadeController@salvar");
        Route::put("/atualizar", "CidadeController@atualizar");
    });
    Route::group(["prefix" => "endereco","namespace" => "localizacao"], function () {
        Route::delete("/{id}/excluir", "EnderecoController@excluir");
        Route::post("/salvar", "EnderecoController@salvar");
        Route::put("/atualizar", "EnderecoController@atualizar");
    });
});


