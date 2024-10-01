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
        Schema::create('clientes_representantes', function (Blueprint $table) {
            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('representante_id');
            $table->primary(['cliente_id', 'representante_id']);
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->foreign('representante_id')->references('id')->on('representantes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients_representatives');
    }
};
