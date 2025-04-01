<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;

class DownloadModelosController extends Controller
{
    public function downloadDocumentoGerado(Evento $evento, $tipo)
    {
        switch ($tipo) {
            case 'propostaDocx':
                $path = storage_path('/app/public/eventos/') . $evento->id . '/proposta.docx';
                break;

            case 'propostaPdf':
                $path = storage_path('/app/public/eventos/') . $evento->id . '/proposta.pdf';
                break;

            case 'declaracoesDocx':
                $path = storage_path('/app/public/eventos/') . $evento->id . '/declaracoes.docx';
                break;

            case 'declaracoesPdf':
                $path = storage_path('/app/public/eventos/') . $evento->id . '/declaracoes.pdf';
                break;

            case 'declaracoesEconomicasDocx':
                $path = storage_path('/app/public/eventos/') . $evento->id . '/declaracoes_economicas.docx';
                break;

            case 'declaracoesEconomicasPdf':
                $path = storage_path('/app/public/eventos/') . $evento->id . '/declaracoes_economicas.pdf';
                break;

            case 'contratoDocx':
                $path = storage_path('/app/public/eventos/') . $evento->id . '/contrato.docx';
                break;

            case 'contratoPdf':
                $path = storage_path('/app/public/eventos/') . $evento->id . '/contrato.pdf';
                break;

            default:
                break;
        }


        return response()->download($path, null, [
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
            'Expires' => 'Sat, 01 Jan 2000 00:00:00 GMT',
        ]);
    }
}
