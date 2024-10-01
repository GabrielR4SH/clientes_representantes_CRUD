<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Cliente;
use App\Models\Representante;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         // Gerar 40 clientes e representantes
         Cliente::factory(40)->create();
         Representante::factory(40)->create();
    }
}
