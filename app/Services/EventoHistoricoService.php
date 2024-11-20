<?php

namespace App\Services;

use App\Enums\EventoStatusEnum;
use App\Models\Evento;
use App\Models\EventoHistorico;
use Illuminate\Support\Facades\Auth;

class EventoHistoricoService
{
    public static function gerarHistorico(Evento $evento, EventoStatusEnum $novoStatus, string $observacao = null)
    {
        $eventoHistorico = new EventoHistorico();
        $eventoHistorico->evento_id = $evento->id;
        $eventoHistorico->user_id = Auth::user()->id ?? null;
        $eventoHistorico->status_anterior = $evento->status;
        $eventoHistorico->status_atual = $novoStatus;
        $eventoHistorico->observacao = $observacao;
        $eventoHistorico->save();

        $evento->status = $novoStatus;
        $evento->save();
    }
}
