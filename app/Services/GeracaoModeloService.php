<?php

namespace App\Services;

use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;

class GeracaoModeloService
{


    function substituirTokensNoDocxEConverterPdf($modeloDocx, $dados, $saidaDocx, $saidaPdf)
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
}
