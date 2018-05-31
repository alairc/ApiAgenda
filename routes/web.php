<?php

Route::post('/novocontato',['as' => 'agenda.contato.novo', 'uses' => 'AgendaController@novoContato']);
Route::post('/atualizacontato',['as' => 'agenda.contato.atualiza', 'uses' => 'AgendaController@atualizaContato']);
Route::get('/listacontato',['as' => 'agenda.contato.lista', 'uses' => 'AgendaController@listaContato']);
Route::get('/apagacontato/{idContato}',['as' => 'agenda.contato.apaga', 'uses' => 'AgendaController@apagaContato']);
Route::get('/listamensagem/{idMensagem}',['as' => 'agenda.mensagem.lista', 'uses' => 'AgendaController@listaMensagem']);
Route::get('/apagamensagem/{idMensagem}',['as' => 'agenda.mensagem.apaga', 'uses' => 'AgendaController@apagaMensagem']);
Route::post('/novamensagem',['as' => 'agenda.mensagem.novo', 'uses' => 'AgendaController@novaMensagem']);

