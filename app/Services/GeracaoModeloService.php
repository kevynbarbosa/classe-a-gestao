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

        // Tabela de descrição dos serviços
        $table = new Table([
            'borderSize' => 6,
            'borderColor' => 'white',
            'width' => 100 * 50, // 100% x (1/50)
            'unit' => TblWidth::PERCENT,
        ]);
        $table->addRow(200);
        $table->addCell(40 * 50, ['bgColor' => 'black', 'valign' => 'center'])->addText('SERVIÇO', ['bold' => true, 'color' => 'white'], ['alignment' => Jc::CENTER, 'spaceAfter' => 200, 'spaceBefore' => 200]);
        $table->addCell(60 * 50, ['bgColor' => 'black', 'valign' => 'center'])->addText('VALORES', ['bold' => true, 'color' => 'white'], ['alignment' => Jc::CENTER, 'spaceAfter' => 200, 'spaceBefore' => 200]);

        foreach ($dados['TABELA_SERVICOS'] as $servico) {
            $table->addRow();
            $table->addCell(null, ['bgColor' => 'black'])->addText($servico['DESCRICAO'], ['color' => 'white'], ['spaceAfter' => 150, 'spaceBefore' => 150]);
            $table->addCell(null, ['bgColor' => 'black'])->addText('R$ ' . number_format($servico['VALOR'], 2, ',', '.'), ['color' => 'white'], ['alignment' => Jc::END, 'spaceAfter' => 150, 'spaceBefore' => 150]);
        }

        $total = $dados['TABELA_SERVICOS']->sum('VALOR');
        $table->addRow();
        $table->addCell(null, ['bgColor' => 'black'])->addText('TOTAL', ['bold' => true, 'color' => 'white'], ['spaceAfter' => 150, 'spaceBefore' => 150]);
        $table->addCell(null, ['bgColor' => 'black'])->addText('R$ ' . number_format($total, 2, ',', '.'), ['bold' => true, 'color' => 'white'], ['alignment' => Jc::END, 'spaceAfter' => 150, 'spaceBefore' => 150]);

        $templateProcessor->setComplexBlock('table', $table);

        // Salvar o arquivo Word com os dados substituídos
        $templateProcessor->saveAs($pathDocx);
    }

    private function converteEmPdf($pathDocx, $pathPdf)
    {
        // dd($pathDocx);
        $outputDir = $pathPdf;
        $result = null;
        $output = null;
        exec("libreoffice --convert-to pdf $pathDocx --outdir $outputDir", $output, $result);
        // dd($output, $result);

        if ($result !== 0) {
            throw new \Exception("Erro ao converter o arquivo Word para PDF.");
        }
    }


    function gerarProposta(Evento $evento)
    {
        $artista = $evento->artista;

        $modeloDocx = storage_path('app/modelos_proposta/MODELO_PROPOSTA.docx');
        $pathDocx = storage_path('app/public/eventos/' . $evento->id . '/proposta.docx');

        $dados = [
            'ARTISTA_NOME' => $artista->nome,
            'ARTISTA_RAZAO_SOCIAL' => $artista->razao_social,
            'ARTISTA_CNPJ' => $artista->cnpj,
            'ARTISTA_ENDERECO' => $artista->endereco,
            'ARTISTA_NUMERO' => $artista->numero,
            'ARTISTA_COMPLEMENTO' => $artista->complemento,
            'ARTISTA_BAIRRO' => $artista->bairro,
            'ARTISTA_CIDADE' => $artista->cidade->nome,
            'ARTISTA_CEP' => $artista->cep,
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
            'TABELA_SERVICOS' => collect($evento->servicos)->map(function ($servico) {
                return [
                    'DESCRICAO' => $servico->descricao,
                    'VALOR' => $servico->valor,
                ];
            }),
        ];

        foreach ($dados as $key => $value) {
            if (is_null($value)) {
                throw new \Exception("O valor para o token '$key' n o pode ser nulo.");
            }
        }

        if ($evento->servicos()->count() <= 0) {
            throw new \Exception("O evento não possui serviços cadastrados.");
        }

        Storage::makeDirectory('public/eventos/' . $evento->id);
        $this->substituirTokensNoDocx($modeloDocx, $dados, $pathDocx);
        $this->converteEmPdf($pathDocx, storage_path('app/public/eventos/' . $evento->id));
    }
}
