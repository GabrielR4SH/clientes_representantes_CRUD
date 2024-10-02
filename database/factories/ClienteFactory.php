<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Cidade;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ClienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => $this->faker->name,
            'cpf' => $this->faker->numerify('###########'),
            'data_nascimento' => $this->faker->date(),
            'idade' => $this->faker->numberBetween(18, 80),
            'sexo' => $this->faker->randomElement(['M', 'F']),
            'estado' => $this->faker->stateAbbr, // Gerando o estado diretamente na factory de clientes
            'cidade_id' => Cidade::factory(), // Relaciona com uma cidade gerada pela factory de cidades
        ];
    }
}
