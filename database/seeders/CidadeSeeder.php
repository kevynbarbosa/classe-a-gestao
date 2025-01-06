<?php

namespace Database\Seeders;

use App\Models\Cidade;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class CidadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Cidade::count() > 10) return;

        // Caminho do arquivo CSV no storage
        $filePath = 'seeders/municipios.csv'; // Altere para o caminho correto do arquivo

        if (!Storage::exists($filePath)) {
            $this->command->error("Arquivo CSV não encontrado: $filePath");
            return;
        }

        $file = fopen(Storage::path($filePath), 'r');

        // Ignorar a primeira linha (cabeçalho)
        fgetcsv($file);

        while (($data = fgetcsv($file, 1000, ',')) !== false) {

            // dd($data);

            Cidade::create([
                'municipio' => $data[0],
                'uf' => $data[1],
                'uf_codigo' => $data[2],
                'nome' => $data[3],
                'meso_regiao' => $data[4],
                'micro_regiao' => $data[5],
                'rgint' => $data[6],
                'rgi' => $data[7],
                'osm_relation_id' => $data[8],
                'wikidata_id' => $data[9],
                'is_capital' => $data[10],
                'wikipedia_pt' => $data[11],
                'lon' => $data[12],
                'lat' => $data[13],
                'sem_acentos' => $data[14],
                'slug_name' => $data[15],
                'nomes_alternativos' => $data[16],
                'pop_21' => $data[17],
            ]);
        }

        // Fecha o arquivo
        fclose($file);
    }
}
