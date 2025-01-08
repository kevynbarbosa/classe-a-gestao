<?php

namespace Database\Seeders;

use App\Models\DocumentoInternoCategoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentoInternoCategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DocumentoInternoCategoria::firstOrCreate(
            [
                'nome' => 'CND FEDERAL'
            ]
        );

        DocumentoInternoCategoria::firstOrCreate(
            [
                'nome' => 'CND ESTADUAL'
            ]
        );

        DocumentoInternoCategoria::firstOrCreate(
            [
                'nome' => 'CND PREFEITURA'
            ]
        );

        DocumentoInternoCategoria::firstOrCreate(
            [
                'nome' => 'CND FGTS'
            ]
        );

        DocumentoInternoCategoria::firstOrCreate(
            [
                'nome' => 'CND FALÊNCIA E CONCORDATA'
            ]
        );
    }
}
