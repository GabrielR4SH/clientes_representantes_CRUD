<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100);
            $table->string('cpf', 11)->unique();
            $table->date('data_nascimento');
            $table->char('sexo', 1)->nullable();
            $table->unsignedBigInteger('cidade_id')->nullable();
            $table->string('estado', 2); // Adicionando o campo 'estado'
            $table->foreign('cidade_id')->references('id')->on('cidades')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
