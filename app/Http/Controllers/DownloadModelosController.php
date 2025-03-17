<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;

class DownloadModelosController extends Controller
{
    public function downloadPdfProposta(Evento $evento)
    {
        $path = storage_path('/app/public/eventos/') . $evento->id . '/proposta.pdf';
        return response()->download($path, null, [
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
            'Expires' => 'Sat, 01 Jan 2000 00:00:00 GMT',
        ]);
    }

    public function downloadWordProposta(Evento $evento)
    {
        $path = storage_path('/app/public/eventos/') . $evento->id . '/proposta.docx';
        return response()->download($path, null, [
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
            'Expires' => 'Sat, 01 Jan 2000 00:00:00 GMT',
        ]);
    }

    public function downloadPdfDeclaracao(Evento $evento)
    {
        $path = storage_path('/app/public/eventos/') . $evento->id . '/declaracoes.pdf';
        return response()->download($path, null, [
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
            'Expires' => 'Sat, 01 Jan 2000 00:00:00 GMT',
        ]);
    }

    public function downloadWordDeclaracao(Evento $evento)
    {
        $path = storage_path('/app/public/eventos/') . $evento->id . '/declaracoes.docx';
        return response()->download($path, null, [
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
            'Expires' => 'Sat, 01 Jan 2000 00:00:00 GMT',
        ]);
    }
}
