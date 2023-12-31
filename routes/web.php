<?php

use App\Http\Controllers\platillosController;
use App\Http\Controllers\usuariosController;
use App\Http\Controllers\rolesController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\permisoController;
use App\Http\Controllers\cambioContraseñaController;
use App\Http\Controllers\asignacion;
use App\Http\Controllers\rutasController;
use App\Http\Controllers\clientesController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\autenticacion;

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
Route::middleware([autenticacion::class])->group(function () {
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
    Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');
    Route::post('/cambiarPassword', [cambioContraseñaController::class, 'cambiarPassword'])->name('cambiarPassword');
    Route::get('/obtenerPermisosCreados', [permisoController::class, 'obtenerPermisosCreados'])->name('obtenerPermisosCreados');
    Route::post('/guardarPermiso', [permisoController::class, 'guardarPermiso'])->name('guardarPermiso');
    Route::post('/guardarPermisoEditado', [permisoController::class, 'guardarPermisoEditado'])->name('guardarPermisoEditado');
    Route::post('/guardarPermisosAgregados', [permisoController::class, 'guardarPermisosAgregados'])->name('guardarPermisosAgregados');
    Route::post('/eliminarPermiso', [permisoController::class, 'eliminarPermiso'])->name('eliminarPermiso');
    Route::get('/obtenerPermisosAsignados', [asignacion::class, 'obtenerPermisosAsignados'])->name('obtenerPermisosAsignados');
    Route::get('/obtenerRoles', [asignacion::class, 'obtenerRoles'])->name('obtenerRoles');
    Route::post('/guardarAsignacion', [asignacion::class, 'guardarAsignacion'])->name('guardarAsignacion');
    Route::post('/guardarAsignacionEditada', [asignacion::class, 'guardarAsignacionEditada'])->name('guardarAsignacionEditada');
    Route::post('/eliminarAsignacion', [asignacion::class, 'eliminarAsignacion'])->name('eliminarAsignacion');
    Route::get('/obtenerRutas', [rutasController::class, 'obtenerRutas'])->name('obtenerRutas');
});
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/obtenerPlatillosClientes', [clientesController::class, 'obtenerPlatillosClientes'])->name('obtenerPlatillosClientes');

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');
