<?php

namespace Database\Factories;

use App\Models\Cidade;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Artista>
 */
class ArtistaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => fake()->name(),
            'razao_social' => fake()->company(),
            'cnpj' => fake()->numerify('##.###.###/####-##'),
            'email' => fake()->unique()->safeEmail(),
            'telefone' => fake()->phoneNumber(),
            'endereco' => fake()->streetAddress(),
            'numero' => fake()->buildingNumber(),
            'complemento' => fake()->secondaryAddress(),
            'bairro' => fake()->citySuffix(),
            'cep' => fake()->postcode(),
            'cidade_id' => Cidade::inRandomOrder()->first()->id,
            'representante_legal_nome' => fake()->name(),
            'representante_legal_cpf' => fake()->numerify('###.###.###-##'),
            'representante_legal_rg' => fake()->numerify('##.###.###-#'),
            'representante_legal_email' => fake()->unique()->safeEmail(),
            'color' => fake()->hexColor(),
            'logo_path' => fake()->imageUrl(200, 200, 'business', true, 'logo'),
        ];
    }
}
