<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;

Route::get('index', [ClienteController::class, 'index'])->name('clientes.index');
Route::post('clientes', [ClienteController::class, 'store'])->name('clientes.store');
Route::get('clientes/{id}/edit', [ClienteController::class, 'edit'])->name('clientes.edit');
Route::put('clientes/{id}', [ClienteController::class, 'update'])->name('clientes.update'); // Adicionada rota de atualização
Route::delete('clientes/{id}', [ClienteController::class, 'destroy'])->name('clientes.destroy');
