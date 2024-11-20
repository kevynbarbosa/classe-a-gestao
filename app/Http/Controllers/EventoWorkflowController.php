<?php

namespace App\Http\Controllers;

use App\Enums\EventoStatusEnum;
use App\Models\Evento;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EventoWorkflowController extends Controller
{
    public function show(Evento $evento)
    {
        $evento->load(['artista', 'contratante', 'vendedor', 'cidade']);

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

        $evento->status = EventoStatusEnum::FORMULARIO_ENVIADO;
        $evento->save();

        return back();
    }

    public function showFormulario($token)
    {
        // $evento = Evento::where('token', $token)->first();
        $evento = Evento::find(1);
        if ($evento->status == EventoStatusEnum::FORMULARIO_ENVIADO) {
            return Inertia::render('EventoWorkflow/Formulario', [
                'evento' => $evento,
            ]);
        }

        return Inertia::render('EventoWorkflow/FormularioConcluido',);
    }

    public function salvarFormulario(Request $request, $token)
    {
        $validatedData = $request->validate([
            // 'email_contratante' => ['required', 'email'],
        ]);

        // $evento = Evento::where('token', $token)->first();
        $evento = Evento::find(1);
        if (!$evento->status == EventoStatusEnum::FORMULARIO_ENVIADO) {
            return 'expirado';
        };

        $evento->status = EventoStatusEnum::PENDENTE_PROPOSTA;
        $evento->save();

        return back();
    }

    public function gerarProposta(Request $request, Evento $evento)
    {
        $validatedData = $request->validate([
            // 'email_contratante' => ['required', 'email'],
        ]);

        $evento->status = EventoStatusEnum::PROPOSTA_ENVIADA;
        $evento->save();

        return back();
    }
}
