<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ClienteRepresentante extends Pivot
{
    use HasFactory;

    // Define o nome da tabela
    protected $table = 'clientes_representantes';

    // Definindo os campos preenchíveis (campos da tabela intermediária)
    protected $fillable = ['cliente_id', 'representante_id'];

    // Desativa o uso automático de timestamps (caso não sejam usados)
    public $timestamps = false;

    // Definindo a relação com o modelo Cliente
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    // Definindo a relação com o modelo Representante
    public function representante(): BelongsTo
    {
        return $this->belongsTo(Representante::class, 'representante_id');
    }
}
