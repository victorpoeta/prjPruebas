<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
/*
Route::get('/', function () {
    return view('welcome');
});
*/

//Route::get('/ConsultarEP','EstatusPagoController@getListaEstatusPago');

//Route::get('consultarEP',['uses' => 'Wscanguroazul\EstatusPagoController@getListaEstatusPago', 'as' => 'consultarEP']);

//Route::get('consultarEP','Wscanguroazul\Wspagos\EstatusPagoController@getListaEstatusPago');

//Route::get('consultarEP','Wscanguroazul\Wspagos\ConsumerController@consumerConsultaEstatusPago');

Route::get('consultaDirectaEP',['uses' => 'Wscanguroazul\Wspagos\EstatusPagoController@getListaEstatusPago', 'as' => 'consultaDirectaEP']);

//Route::get('ListaEP',['uses' => 'Wscanguroazul\Wspagos\ConsumerController@consumerConsultaEstatusPago', 'as' => 'ListaEP']);

Route::get('listaEstatusPago',['uses' => 'Wscanguroazul\Wspagos\ConsumerController@listaEstatusPago', 'as' => 'listaEstatusPago']);

