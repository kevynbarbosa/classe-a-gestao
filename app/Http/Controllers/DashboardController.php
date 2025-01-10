<?php

namespace App\Http\Controllers;

use App\Models\DocumentoInterno;
use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard', [
            'documentos_internos' => $this->getDocumentosInternos(),
            'proximos_eventos' => $this->getProximosEventos(),
            'campanhas' => $this->getCampanhas(),
            'eventos_realizados_artista' => $this->getEventosRealizadosArtista(),
            'eventos_futuros_artista' => $this->getEventosFuturosArtista(),
            'eventos_totais_artista' => $this->getEventosTotaisArtista(),
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
        $eventos = Evento::where('data_hora', '>=', now())->where('data_hora', '<=', now()->addDays(7))->orderBy('data_hora')->with(['artista', 'contratante', 'cidade'])->get();
        return $eventos;
    }

    private function getCampanhas()
    {
        return null;
    }

    private function getEventosRealizadosArtista()
    {
        $eventos = Evento::leftJoin('artistas', 'artistas.id', '=', 'eventos.artista_id')
            ->select('artistas.nome', DB::raw('count(*) as total'))
            ->where('data_hora', '<', now())
            ->groupBy('artista_id')
            ->get();

        return $eventos;
    }

    private function getEventosFuturosArtista()
    {
        $eventos = Evento::leftJoin('artistas', 'artistas.id', '=', 'eventos.artista_id')
            ->select('artistas.nome', DB::raw('count(*) as total'))
            ->where('data_hora', '>=', now())
            ->groupBy('artista_id')
            ->get();

        return $eventos;
    }

    private function getEventosTotaisArtista()
    {
        return null;
    }
}
