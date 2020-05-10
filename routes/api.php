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
/*
Route::group(["prefix" => "cidade","namespace" => "localizacao"], function () {
    Route::get("/{id}/excluir", "CidadeController@excluir");
    Route::get("/{id}", "CidadeController@getCidade");
    Route::get("/{estadoId}/estado", "CidadeController@ggetCidadePorEstado");
    Route::post("/salvar", "CidadeController@salvar");
    Route::post("/atualizar", "CidadeController@atualizar");
});
*/

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('user', 'UserController@getAuthenticatedUser');
    Route::get('closed', 'DataController@closed');

    //localizacao
    Route::group(["prefix" => "pais","namespace" => "localizacao"], function () {    
        Route::delete("/{id}/excluir", "PaisController@excluir");
        Route::post("/salvar", "PaisController@salvar");
        Route::Put("/atualizar", "PaisController@atualizar");
        
    });
});


