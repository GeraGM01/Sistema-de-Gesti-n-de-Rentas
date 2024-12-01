<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CasaController;
use App\Http\Controllers\RentaController; 

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::post('/casas/municipios', [HomeController::class, 'obtenerMunicipios'])->name('casas.municipios');
Route::post('casas', [HomeController::class, 'guardar'])->name('casas.guardar'); 
Route::get('/casas/editar/{id}', [CasaController::class, 'editar'])->name('casas.editar');
Route::put('/casas/actualizar/{id}', [CasaController::class, 'actualizar'])->name('casas.actualizar');
Route::delete('/casas/eliminar/{id}', [CasaController::class, 'eliminar'])->name('casas.eliminar');
Route::delete('/imagenes/eliminar/{id}', [CasaController::class, 'destroy'])->name('imagenes.eliminar');


Route::post('/propiedades/{id}/rentar', [RentaController::class, 'rentar'])->name('propiedades.rentar');
Route::get('/mis-rentas', [RentaController::class, 'misRentas'])->name('rentas.mis-rentas');



