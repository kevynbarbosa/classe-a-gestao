<?php

namespace App\Services;

use App\Models\Evento;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\SimpleType\TblWidth;
use PhpOffice\PhpWord\SimpleType\TextAlignment;

class GeracaoModeloService
{
    function substituirTokensNoDocx($modeloDocx, $dados, $pathDocx)
    {
        // Carregar o template do Word
        $templateProcessor = new TemplateProcessor($modeloDocx);

        // Substituir os tokens no arquivo Word
        foreach ($dados as $token => $valor) {
            $templateProcessor->setValue($token, $valor);
        }

        // Salvar o arquivo Word com os dados substituídos
        $templateProcessor->saveAs($pathDocx);
    }

    private function converteEmPdf($pathDocx, $pathPdf)
    {
        // dd($pathDocx);
        $outputDir = $pathPdf;
        $result = null;
        $output = null;
        exec("libreoffice --headless --invisible --norestore --convert-to pdf $pathDocx --outdir $outputDir", $output, $result);
        // dd($output, $result);

        if ($result !== 0) {
            throw new \Exception("Erro ao converter o arquivo Word para PDF.");
        }
    }


    function gerarProposta(Evento $evento)
    {
        $artista = $evento->artista;

        $modeloDocx = resource_path('modelos_proposta/MODELO_PROPOSTA.docx');
        $pathDocx = storage_path('app/public/eventos/' . $evento->id . '/proposta.docx');

        $dados = [
            'CONTRATANTE_NOME' => $evento->contratante->nome_completo,
            'ARTISTA_NOME' => $artista->nome,
            'ARTISTA_RAZAO_SOCIAL' => $artista->razao_social,
            'ARTISTA_CNPJ' => $artista->cnpj,
            'ARTISTA_ENDERECO' => $artista->endereco,
            'ARTISTA_NUMERO' => $artista->numero,
            'ARTISTA_COMPLEMENTO' => $artista->complemento,
            'ARTISTA_BAIRRO' => $artista->bairro,
            'ARTISTA_CIDADE' => $artista->cidade->nome,
            'ARTISTA_CEP' => $artista->cep,
            'ARTISTA_TELEFONE' => $artista->telefone,
            'ARTISTA_EMAIL' => $artista->email,
            'ARTISTA_REPRESENTANTE_LEGAL_NOME' => $artista->representante_legal_nome,
            'ARTISTA_REPRESENTANTE_LEGAL_CPF' => $artista->representante_legal_cpf,
            'ARTISTA_REPRESENTANTE_LEGAL_RG' => $artista->representante_legal_rg,
            'EVENTO_CIDADE' => $evento->cidade->nome,
            'EVENTO_DURACAO' => $evento->duracao,
            'EVENTO_DATA' => Carbon::parse($evento->data_hora)->format('d/m/Y H:i'),
            'EVENTO_RECINTO' => $evento->recinto,
            'EVENTO_VALOR' => number_format($evento->valor, 2, ',', '.'),
            'EVENTO_VALOR_EXTENSO' => MonetaryService::numberToExt($evento->valor),
            'PROPOSTA_DATA_GERACAO' => date('d/m/Y'),

            'RATEIO_1' => $evento->valor * 0.422,
            'RATEIO_2' => $evento->valor * 0.15,
            'RATEIO_3' => $evento->valor * 0.2,
            'RATEIO_4' => $evento->valor * 0.06,
            'RATEIO_5' => $evento->valor * 0.058,
        ];

        foreach ($dados as $key => $value) {
            if (is_null($value)) {
                throw new \Exception("O valor para o token '$key' n o pode ser nulo.");
            }
        }

        Storage::makeDirectory('public/eventos/' . $evento->id);
        $this->substituirTokensNoDocx($modeloDocx, $dados, $pathDocx);
        $this->converteEmPdf($pathDocx, storage_path('app/public/eventos/' . $evento->id));
    }
}
