<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Evento;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Enums\EventoStatusEnum;
use Illuminate\Support\Facades\Mail;
use App\Mail\FormularioContratanteMail;
use App\Services\EventoHistoricoService;

class EventoWorkflowController extends Controller
{
    public function show(Evento $evento)
    {
        $evento->load(['artista', 'contratante', 'vendedor', 'cidade', 'historico']);

        return Inertia::render('EventoWorkflow/Index', [
            'evento' => $evento,
            'evento_status_enum' => EventoStatusEnum::options()
        ]);
    }

    public function enviarFormulario(Request $request, Evento $evento)
    {
        $validatedData = $request->validate([
            'email_contratante' => ['required', 'email'],
        ]);

        try {
            $evento->email_formulario = $validatedData['email_contratante'];
            $evento->token_formulario = Str::uuid();
            $evento->save();

            Mail::to($validatedData['email_contratante'])->send(new FormularioContratanteMail($evento));
        } catch (\Throwable $th) {
            throw $th;
        }

        EventoHistoricoService::gerarHistorico($evento, EventoStatusEnum::FORMULARIO_ENVIADO);

        return back();
    }

    public function showFormulario(Evento $evento)
    {
        if ($evento->status == EventoStatusEnum::FORMULARIO_ENVIADO) {
            $evento->formulario_acessado = true;
            $evento->save();
            return Inertia::render('EventoWorkflow/Formulario', [
                'evento' => $evento,
            ]);
        }

        return Inertia::render('EventoWorkflow/FormularioConcluido',);
    }

    public function salvarFormulario(Request $request, Evento $evento)
    {
        $validatedData = $request->validate([
            // 'email_contratante' => ['required', 'email'],
        ]);

        if (!$evento->status == EventoStatusEnum::FORMULARIO_ENVIADO) {
            return 'expirado';
        };

        EventoHistoricoService::gerarHistorico($evento, EventoStatusEnum::PENDENTE_PROPOSTA);

        return back();
    }

    public function gerarProposta(Request $request, Evento $evento)
    {
        $validatedData = $request->validate([
            // 'email_contratante' => ['required', 'email'],
        ]);

        EventoHistoricoService::gerarHistorico($evento, EventoStatusEnum::PROPOSTA_ENVIADA);

        return back();
    }
}
