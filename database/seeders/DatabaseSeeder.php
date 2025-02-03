<?php

namespace Database\Seeders;

use App\Models\Artista;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (!User::where('email', 'test@example.com')->exists()) {
            User::create([
                'email' => 'kevynbarbosa1@gmail.com',
                'name' => 'Kevyn Barbosa',
                'password' => Hash::make('password'),
            ]);

            // User::factory()->create([
            //     'email' => 'divulgacaosp1@hotmail.com',
            //     'name' => 'Alexandre Souto',
            //     'password' => Hash::make('password'),
            // ]);

            // User::factory()->create([
            //     'email' => 'tiraosi@yahoo.com',
            //     'name' => 'Adriana Oliveira',
            //     'password' => Hash::make('password'),
            // ]);
        }

        $this->call([
            CidadeSeeder::class,
            ArtistaSeeder::class,
            ContratanteSeeder::class,
            VendedorSeeder::class,
            DocumentoInternoCategoriaSeeder::class
        ]);
    }
}
