<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\EventController; //Herdando o Controller EventController que foi criado

Route::get('/',[EventController::class, 'index']); // INDEX MÉTODO QUE MOSTRA TODOS OS REGISTROS ROTA PARA A PAGINA DE INDICE

                                                                //o middleware auth só deixar entrar na rota quem estiver autenticado.
Route::get('/events/create',[EventController::class, 'create'])->middleware('auth'); //METODO CREATE PARA MOSTRAR O FORMULÁRIO DE CRIACAO 
Route::get('/events/{id}',[EventController::class, 'show']);// show metodo que mostra um registro unico
Route::post('/events', [EventController::class, 'store']); // MÉTODO QUE ENVIA O POST PRO CONTROLLER PARA GRAVACAO
Route::delete('/events/{id}', [EventController::class, 'destroy'])->middleware('auth'); 
Route::get('/events/edit/{id}', [EventController::class, 'edit'])->middleware('auth'); // manda os dados pra view de edicao
Route::put('/events/update/{id}', [EventController::class, 'update'])->middleware('auth'); // recebe os dados e envia pro banco na edicao

Route::get('/contato', function () {
    return view('contato');
});

//Rota criada para a dashboard  em eventos.
Route::get('dashboard',[EventController::class, 'dashboard'])->middleware('auth');
// Rota para se juntar a um evento
Route::post('/events/join/{id}', [EventController::class, 'joinEvent'])->middleware('auth');
Route::delete('/events/leave/{id}', [EventController::class, 'leaveEvent'])->middleware('auth'); 