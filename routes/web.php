<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CidadeController;
use App\Http\Controllers\RepresentanteController;
use App\Http\Controllers\ClientRepresentativeController;

Route::get('', [ClienteController::class, 'index'])->name('clientes.index');
Route::post('clientes', [ClienteController::class, 'store'])->name('clientes.store');

Route::get('clientes/{id}/edit', [ClienteController::class, 'edit'])->name('clientes.edit');
Route::put('clientes/{id}', [ClienteController::class, 'update'])->name('clientes.update');
Route::delete('clientes/{id}', [ClienteController::class, 'destroy'])->name('clientes.destroy');

Route::get('cidades', [CidadeController::class, 'index'])->name('cidades.index');
Route::post('cidades', [CidadeController::class, 'store'])->name('cidades.store');
Route::put('cidades/{id}', [CidadeController::class, 'update'])->name('cidades.update');
Route::delete('cidades/{id}', [CidadeController::class, 'destroy'])->name('cidades.destroy');

Route::get('representantes', [RepresentanteController::class, 'index'])->name('representantes.index');
Route::post('representantes', [RepresentanteController::class, 'store'])->name('representantes.store');
Route::put('representantes/{id}', [RepresentanteController::class, 'update'])->name('representantes.update');
Route::delete('representantes/{id}', [RepresentanteController::class, 'destroy'])->name('representantes.destroy');

// Atribuição de Representantes
Route::get('clientes/representantes', [ClientRepresentativeController::class, 'index'])->name('clientes.representantes.index');
Route::post('clientes/representantes/{clienteId}', [ClientRepresentativeController::class, 'store'])->name('clientes.representantes.store');
Route::delete('clientes/representantes/{clienteId}/{representanteId}', [ClientRepresentativeController::class, 'destroy'])->name('clientes.representantes.destroy');
