<?php

namespace Database\Seeders;

use App\Models\Artista;
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
            'nome' => 'João de Souza e Bonifácio'
        ]);

        Artista::firstOrCreate([
            'nome' => 'Lourenço e Lourival'
        ]);

        Artista::firstOrCreate([
            'nome' => 'Trio Parada Dura'
        ]);

        Artista::firstOrCreate([
            'nome' => 'Xonadão e Amigos'
        ]);
    }
}
