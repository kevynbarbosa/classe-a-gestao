<?php

namespace Database\Seeders;

use App\Models\Contratante;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContratanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Contratante::firstOrCreate(
            [
                'cpf_cnpj' => '98736353803'
            ],
            [
                'tipo_pessoa' => 'pf',
                'rg' => '999999',
                'nome_completo' => 'Contratante teste',
                'data_nascimento' => '2024-01-01',
            ]
        );
    }
}
