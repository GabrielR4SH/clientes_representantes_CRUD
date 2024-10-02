<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Cliente;
use App\Models\Representante;
use App\Models\Cidade;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         // Gerar 10 clientes e representantes
         Cliente::factory(10)->create();
         Representante::factory(10)->create();
         Cidade::factory(10)->create();
    }
}
