<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Representante extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'cidade_id']; 
    public function cidade()
    {
        return $this->belongsTo(Cidade::class);
    }

    public function clientes()
    {
        return $this->belongsToMany(Cliente::class, 'clientes_representantes');
    }
}
