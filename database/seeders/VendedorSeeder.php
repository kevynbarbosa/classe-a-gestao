<?php

namespace Database\Seeders;

use App\Models\Vendedor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VendedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Vendedor::firstOrCreate(
            [
                'cpf_cnpj' => '98736353803'
            ],
            [
                'tipo_pessoa' => 'pf',
                'rg' => '999999',
                'nome_completo' => 'Vendedor teste',
            ]
        );
    }
}
