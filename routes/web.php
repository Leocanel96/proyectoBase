<?php

use App\Http\Controllers\platillosController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//Dentro del middlewere
//ROUTE::GET('/obtenerPlatillosCreados', 'platillosController@obtenerPlatillosCreados');
Route::get(
    '/obtenerPlatillosCreados',
    [platillosController::class, 'obtenerPlatillosCreados']
)->name('obtenerPlatillosCreados');

Route::get(
    '/tipoPlatillos',
    [platillosController::class, 'tipoPlatillos']
)->name('tipoPlatillos');

Route::post(
    '/guardarPlatillo',
    [platillosController::class, 'guardarPlatillo']
)->name('guardarPlatillo');

Route::post(
    '/guardarPlatilloEditado',
    [platillosController::class, 'guardarPlatilloEditado']
)->name('guardarPlatilloEditado');


Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');

//Route::get()
