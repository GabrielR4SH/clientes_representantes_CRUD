<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;

Route::get('index', [ClienteController::class, 'index'])->name('clientes.index');
Route::get('clientes/{id}/edit', [ClienteController::class, 'edit'])->name('clientes.edit');
Route::delete('clientes/{id}', [ClienteController::class, 'destroy'])->name('clientes.destroy');
