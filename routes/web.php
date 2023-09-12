<?php

use App\Http\Controllers\platillosController;
use App\Http\Controllers\usuariosController;
use App\Http\Controllers\rolesController;
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
Route::get('/obtenerPlatillosCreados', [platillosController::class, 'obtenerPlatillosCreados'])->name('obtenerPlatillosCreados');
Route::get('/tipoPlatillos', [platillosController::class, 'tipoPlatillos'])->name('tipoPlatillos');
Route::post('/guardarPlatillo', [platillosController::class, 'guardarPlatillo'])->name('guardarPlatillo');
Route::post('/guardarPlatilloEditado', [platillosController::class, 'guardarPlatilloEditado'])->name('guardarPlatilloEditado');
Route::post('/eliminarPlatillo', [platillosController::class, 'eliminarPlatillo'])->name('eliminarPlatillo');
Route::get('/obtenerUsuariosCreados', [usuariosController::class, 'obtenerUsuariosCreados'])->name('obtenerUsuariosCreados');
Route::get('/rolUsuarios', [usuariosController::class, 'rolUsuarios'])->name('rolUsuarios');
Route::post('/guardarUsuario', [usuariosController::class, 'guardarUsuario'])->name('guardarUsuario');
Route::post('/guardarUsuarioEditado', [usuariosController::class, 'guardarUsuarioEditado'])->name('guardarUsuarioEditado');
Route::post('/desactivarUsuario', [usuariosController::class, 'desactivarUsuario'])->name('desactivarUsuario');
Route::post('/activarUsuario', [usuariosController::class, 'activarUsuario'])->name('activarUsuario');
Route::get('/obtenerRolesCreados', [rolesController::class, 'obtenerRolesCreados'])->name('obtenerRolesCreados');
Route::post('/guardarRol', [rolesController::class, 'guardarRol'])->name('guardarRol');
Route::post('/guardarRolEditado', [rolesController::class, 'guardarRolEditado'])->name('guardarRolEditado');
Route::post('/desactivarRol', [rolesController::class, 'desactivarRol'])->name('desactivarRol');
Route::post('/activarRol', [rolesController::class, 'activarRol'])->name('activarRol');

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');

//Route::get()
