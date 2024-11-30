<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::post('/casas/municipios', [HomeController::class, 'obtenerMunicipios'])->name('casas.municipios');
Route::post('casas', [HomeController::class, 'guardar'])->name('casas.guardar'); 

