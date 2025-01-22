<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\EventoServico;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EventoServicoController extends Controller
{

    public function create(Evento $evento)
    {
        return Inertia::render('EventoWorkflow/Partials/ServicoForm', ['evento' => $evento]);
    }

    public function store(Request $request, Evento $evento)
    {
        $validated = $request->validate([
            'descricao' => 'required',
            'valor' => 'required',
        ]);

        $validated['evento_id'] = $evento->id;

        $eventoServico = EventoServico::create($validated);

        return redirect()->back();
    }

    public function edit(Evento $evento, EventoServico $evento_servico)
    {
        return Inertia::render('EventoWorkflow/Partials/ServicoForm', [
            'evento' => $evento,
            'servico' => $evento_servico,
            'updating' => true
        ]);
    }

    public function update(Request $request, Evento $evento, EventoServico $evento_servico)
    {
        $validated = $request->validate([
            'descricao' => 'required',
            'valor' => 'required',
        ]);

        $evento_servico->update($validated);

        return redirect()->back();
    }

    public function destroy(Evento $evento, EventoServico $evento_servico)
    {
        $evento_servico->delete();

        return redirect()->back();
    }
}
