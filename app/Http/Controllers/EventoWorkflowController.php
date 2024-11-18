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

    public function showFormulario(Evento $evento)
    {
        return Inertia::render('EventoWorkflow/Formulario', [
            'evento' => $evento,
            // 'evento_status_enum' => EventoStatusEnum::options()
        ]);
    }
}
