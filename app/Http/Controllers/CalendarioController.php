<?php

namespace App\Http\Controllers;

use App\Enums\EventoStatusEnum;
use App\Http\Resources\CommonResource;
use App\Models\Evento;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CalendarioController extends Controller
{
    public function index(Request $request)
    {
        $eventos = Evento::with('artista', 'contratante', 'cidade')->get();

        return Inertia::render('Calendario/Index', [
            'eventos' => $eventos,
            'evento_status_enum' => EventoStatusEnum::options()
        ]);
    }

    public function eventoDetalhes(Evento $evento)
    {
        $evento->load(['artista', 'contratante', 'vendedor', 'cidade', 'historico', 'observacoes', 'observacoes.user', 'servicos']);

        return Inertia::render('Calendario/EventoDetalhes', [
            'evento' => $evento,
            'evento_status_enum' => EventoStatusEnum::options()
        ]);
    }
}
