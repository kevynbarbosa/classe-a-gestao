<?php

namespace App\Services;

use App\Models\Evento;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;

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

        // Salvar o arquivo Word com os dados substituídos
        $templateProcessor->saveAs($saidaDocx);

        // Salvar o PDF no caminho especificado
        // $rendererName = Settings::PDF_RENDERER_DOMPDF;
        // $rendererLibraryPath = realpath(base_path()  . '/vendor/dompdf/dompdf');
        // Settings::setPdfRenderer($rendererName, $rendererLibraryPath);

        // $phpWord = IOFactory::load($saidaDocx);
        // $pdfWriter = IOFactory::createWriter($phpWord, 'PDF');
        // $pdfWriter->save($saidaPdf);
    }

    function gerarProposta(Evento $evento)
    {
        $artista = $evento->artista;

        $modeloDocx = storage_path('app/modelos_proposta/MODELO_PROPOSTA.docx');
        $saidaDocx = storage_path('app/public/saida.docx');

        $dados = [
            '{{ARTISTA_NOME}}' => $artista->nome,
            '{{ARTISTA_RAZAO_SOCIAL}}' => $artista->razao_social,
            '{{ARTISTA_CNPJ}}' => $artista->cnpj,
            '{{ARTISTA_ENDERECO}}' => $artista->endereco,
            '{{ARTISTA_NUMERO}}' => $artista->numero,
            '{{ARTISTA_COMPLEMENTO}}' => $artista->complemento,
            '{{ARTISTA_BAIRRO}}' => $artista->bairro,
            '{{ARTISTA_CIDADE}}' => $artista->cidade->nome,
            '{{ARTISTA_CEP}}' => $artista->cep,
            '{{ARTISTA_REPRESENTANTE_LEGAL_NOME}}' => $artista->representante_legal_nome,
            '{{ARTISTA_REPRESENTANTE_LEGAL_CPF}}' => $artista->representante_legal_cpf,
            '{{ARTISTA_REPRESENTANTE_LEGAL_RG}}' => $artista->representante_legal_rg,
            '{{EVENTO_CIDADE}}' => $evento->cidade->nome,
            '{{EVENTO_DURACAO}}' => $evento->duracao,
            '{{EVENTO_DATA}}' => $evento->data,
            '{{EVENTO_RECINTO}}' => $evento->recinto,
            '{{EVENTO_VALOR}}' => $evento->valor,
            '{{EVENTO_VALOR_EXTENSO}}' => $evento->valor_extenso,
            '{{PROPOSTA_DATA_GERACAO}}' => date('d/m/Y'),
        ];

        $this->substituirTokensNoDocxEConverterPdf($modeloDocx, $dados, $saidaDocx);
    }
}
