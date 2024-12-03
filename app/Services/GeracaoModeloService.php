<?php

namespace App\Services;

use App\Models\Evento;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\SimpleType\TblWidth;
use PhpOffice\PhpWord\SimpleType\TextAlignment;

class GeracaoModeloService
{
    function substituirTokensNoDocxEConverterPdf($modeloDocx, $dados, $saidaDocx)
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

        $table->addRow();
        $table->addCell(null, ['bgColor' => 'black'])->addText('Cachê dos artistas/ equipe de músicos/ equipe técnica e operacional', ['color' => 'white'], ['spaceAfter' => 150, 'spaceBefore' => 150]);
        $table->addCell(null, ['bgColor' => 'black'])->addText('R$ 37.980,00', ['color' => 'white'], ['alignment' => Jc::END, 'spaceAfter' => 150, 'spaceBefore' => 150]);

        $table->addRow();
        $table->addCell(null, ['bgColor' => 'black'])->addText('TOTAL', ['bold' => true, 'color' => 'white'], ['spaceAfter' => 150, 'spaceBefore' => 150]);
        $table->addCell(null, ['bgColor' => 'black'])->addText('R$ 90.000,00', ['bold' => true, 'color' => 'white'], ['alignment' => Jc::END, 'spaceAfter' => 150, 'spaceBefore' => 150]);

        $templateProcessor->setComplexBlock('table', $table);

        // Salvar o arquivo Word com os dados substituídos
        $templateProcessor->saveAs($saidaDocx);
    }


    function gerarProposta(Evento $evento)
    {
        $artista = $evento->artista;

        $modeloDocx = storage_path('app/modelos_proposta/MODELO_PROPOSTA.docx');
        $saidaDocx = storage_path('app/public/saida.docx');

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
            'EVENTO_DATA' => $evento->data_hora,
            'EVENTO_RECINTO' => $evento->recinto,
            'EVENTO_VALOR' => $evento->valor,
            // 'EVENTO_VALOR_EXTENSO' => $evento->valor_extenso,
            'PROPOSTA_DATA_GERACAO' => date('d/m/Y'),
        ];

        foreach ($dados as $key => $value) {
            if (is_null($value)) {
                throw new \Exception("O valor para o token '$key' n o pode ser nulo.");
            }
        }

        $this->substituirTokensNoDocxEConverterPdf($modeloDocx, $dados, $saidaDocx);
    }
}
