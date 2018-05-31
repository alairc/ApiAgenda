<?php

use Illuminate\Http\Request;

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

Route::post('/novocontato','AgendaController@novoContato');
Route::post('/atualizacontato','AgendaController@atualizaContato');
Route::post('/atualizamensagem','AgendaController@atualizaMensagem');
Route::get('/listacontato', 'AgendaController@listaContato');
Route::get('/apagacontato/{idContato}','AgendaController@apagaContato');
Route::get('/listamensagem/{idMensagem}','AgendaController@listaMensagem');
Route::get('/apagamensagem/{idMensagem}','AgendaController@apagaMensagem');
Route::post('/novamensagem','AgendaController@novaMensagem');