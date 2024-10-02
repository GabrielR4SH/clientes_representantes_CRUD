<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    public function cidade()
    {
        return $this->belongsTo(Cidade::class);
    }

    public function representantes()
    {
        return $this->belongsToMany(Representante::class, 'clientes_representantes');
    }
}
