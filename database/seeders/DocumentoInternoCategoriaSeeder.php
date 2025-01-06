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
        $cnd_id = DocumentoInternoCategoria::firstOrCreate(
            ['nome' => 'CND - Certidão negativa de débitos']
        );

        DocumentoInternoCategoria::firstOrCreate(
            [
                'categoria_pai_id' => $cnd_id->id,
                'nome' => 'CND FEDERAL'
            ]
        );

        DocumentoInternoCategoria::firstOrCreate(
            [
                'categoria_pai_id' => $cnd_id->id,
                'nome' => 'CND ESTADUAL'
            ]
        );

        DocumentoInternoCategoria::firstOrCreate(
            [
                'categoria_pai_id' => $cnd_id->id,
                'nome' => 'CND PREFEITURA'
            ]
        );

        DocumentoInternoCategoria::firstOrCreate(
            [
                'categoria_pai_id' => $cnd_id->id,
                'nome' => 'CND FGTS'
            ]
        );

        DocumentoInternoCategoria::firstOrCreate(
            [
                'categoria_pai_id' => $cnd_id->id,
                'nome' => 'CND FALÊNCIA E CONCORDATA'
            ]
        );
    }
}
