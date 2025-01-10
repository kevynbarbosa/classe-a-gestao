<?php

namespace App\Http\Controllers;

use App\Models\DocumentoInterno;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard', [
            'documentos_internos' => $this->getDocumentosInternos(),
            'proximos_eventos' => null,
            'campanhas' => null,
            'eventos_realizados_artista' => null,
            'eventos_futuros_artista' => null,
            'eventos_totais_artista' => null
        ]);
    }

    private function getDocumentosInternos()
    {
        $data_validade = now()->addDays(7);
        $documentos = DocumentoInterno::where('data_validade', '<=', $data_validade)->with(['categoria', 'artista'])->get();

        return $documentos;
    }

    private function getProximosEventos()
    {
        return null;
    }
}
