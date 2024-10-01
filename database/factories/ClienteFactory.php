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
            'idade' => $this->faker->numberBetween(18, 80),
            'sexo' => $this->faker->randomElement(['M', 'F']),
            'cidade_id' => Cidade::factory(),
        ];
    }
}
