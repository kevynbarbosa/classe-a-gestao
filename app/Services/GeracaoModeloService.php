<?php

namespace App\Services;

use App\Models\Evento;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;

class GeracaoModeloService
{

    public function __construct(public Evento $evento) {}

    function substituirTokensNoDocx($modeloDocx, $dados, $pathDocx)
    {
        // Carregar o template do Word
        $templateProcessor = new TemplateProcessor($modeloDocx);

        // Substituir os tokens no arquivo Word
        foreach ($dados as $token => $valor) {
            $templateProcessor->setValue($token, htmlspecialchars($valor, ENT_QUOTES, 'UTF-8'));
        }

        // if ($this->evento->artista->logo_path) {
        //     $templateProcessor->setImageValue('IMAGEM', [
        //         'path' => $this->evento->artista->logo_path, // Caminho da imagem
        //         // 'width' => 200, // Largura em pixels
        //         // 'height' => 150, // Altura em pixels
        //         // 'ratio' => true // Mantém a proporção da imagem
        //     ]);
        // }

        // Salvar o arquivo Word com os dados substituídos
        $templateProcessor->saveAs($pathDocx);
    }

    private function alterarCores($pathDocx)
    {
        $baseColor = 'fffac2';
        $artista = $this->evento->artista;
        $newColor = $artista->color ?? 'fffac2';

        $zip = new \ZipArchive();
        $zip->open($pathDocx);
        $content = $zip->getFromName('word/document.xml');

        $content = str_replace("#$baseColor", "#$newColor", $content);
        $content = str_replace(strtolower($baseColor), strtolower($newColor), $content);
        $content = str_replace(strtoupper($baseColor), strtoupper($newColor), $content);

        $zip->deleteName('word/document.xml');
        $zip->addFromString('word/document.xml', $content);
        $zip->close();
    }

    private function converteEmPdf($pathDocx, $pathPdf)
    {
        // dd($pathDocx);
        $outputDir = $pathPdf;
        $result = null;
        $output = null;
        exec("libreoffice --headless --invisible --norestore --convert-to pdf $pathDocx --outdir $outputDir", $output, $result);
        // dd($output, $result, $pathDocx, $outputDir, "libreoffice --headless --invisible --norestore --convert-to pdf $pathDocx --outdir $outputDir");

        if ($result !== 0) {
            throw new \Exception("Erro ao converter o arquivo Word para PDF.");
        }
    }


    function gerarProposta()
    {
        $artista = $this->evento->artista;

        $modeloDocx = resource_path('modelos_proposta/MODELO_PROPOSTA.docx');
        $pathDocx = storage_path('app/public/eventos/' . $this->evento->id . '/proposta.docx');

        $dados = [
            'CONTRATANTE_NOME' => $this->evento->contratante->nome_completo,
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
            'EVENTO_CIDADE' => $this->evento->cidade->nome,
            'EVENTO_DURACAO' => $this->evento->duracao,
            'EVENTO_DATA' => Carbon::parse($this->evento->data_hora)->format('d/m/Y H:i'),
            'EVENTO_RECINTO' => $this->evento->recinto,
            'EVENTO_VALOR' => number_format($this->evento->valor, 2, ',', '.'),
            'EVENTO_VALOR_EXTENSO' => MonetaryService::numberToExt($this->evento->valor),
            'PROPOSTA_DATA_GERACAO' => date('d/m/Y'),

            'RATEIO_1' => $this->evento->valor * 0.422,
            'RATEIO_2' => $this->evento->valor * 0.15,
            'RATEIO_3' => $this->evento->valor * 0.2,
            'RATEIO_4' => $this->evento->valor * 0.06,
            'RATEIO_5' => $this->evento->valor * 0.058,
        ];

        // dd($dados);

        foreach ($dados as $key => $value) {
            if (is_null($value)) {
                throw new \Exception("O valor para o token '$key' n o pode ser nulo.");
            }
        }

        Storage::makeDirectory('public/eventos/' . $this->evento->id);
        // Proposta
        $this->substituirTokensNoDocx($modeloDocx, $dados, $pathDocx);
        $this->alterarCores($pathDocx);
        $this->converteEmPdf($pathDocx, storage_path('app/public/eventos/' . $this->evento->id));

        // Declarações
        $this->substituirTokensNoDocx(resource_path('modelos_proposta/DECLARACOES.docx'), $dados, storage_path('app/public/eventos/' . $this->evento->id . '/declaracoes.docx'));
        $this->converteEmPdf(storage_path('app/public/eventos/' . $this->evento->id . '/declaracoes.docx'), storage_path('app/public/eventos/' . $this->evento->id));

        // Declarações econômicas
        $this->substituirTokensNoDocx(resource_path('modelos_proposta/DECLARACOES_ECONOMICAS.docx'), $dados, storage_path('app/public/eventos/' . $this->evento->id . '/declaracoes_economicas.docx'));
        $this->converteEmPdf(storage_path('app/public/eventos/' . $this->evento->id . '/declaracoes_economicas.docx'), storage_path('app/public/eventos/' . $this->evento->id));
    }
}
