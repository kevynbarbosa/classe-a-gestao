<?php

namespace Database\Seeders;

use App\Models\Artista;
use App\Models\Cidade;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArtistaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Artista::firstOrCreate([
            'nome' => 'Lourenço e Lourival',
            'razao_social' => 'LOURENÇO E LOURIVAL PRODUÇÕES E PROMOÇÕES ARTÍSTICAS LTDA',
            'cnpj' => '52782076000110',
            'email' => 'lourencoelourivaloficial@hotmail.com',
            'telefone' => '11986896001',
            'endereco' => 'Rua Padre Euclides',
            'numero' => '385',
            'complemento' => 'apto 24',
            'bairro' => 'Campos Elíseos',
            'cep' => '14080200',
            'cidade_id' => Cidade::where('municipio', 3543402)->first()->id, // Ribeirao Preto - SP
            'representante_legal_nome' => 'ALINE PATRÍCIA DE SOUZA CORRÊA',
            'representante_legal_cpf' => '30961177802',
            'representante_legal_rg' => '40.094.784-5-SSP/SP',
            'representante_legal_email' => 'lourencoelourivaloficial@hotmail.com',
        ]);

        // Artista::firstOrCreate([
        //     'nome' => 'João de Souza e Bonifácio',
        // ]);

        // Artista::firstOrCreate([
        //     'nome' => 'Trio Parada Dura'
        // ]);

        // Artista::firstOrCreate([
        //     'nome' => 'Xonadão e Amigos'
        // ]);
    }
}
