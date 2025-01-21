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

    public function edit(EventoServico $eventoServico)
    {
        return Inertia::render('EventoWorkflow/Partials/ServicoForm', [
            'eventoServico' => $eventoServico,
            'updating' => true
        ]);
    }

    public function update(Request $request, Evento $evento, EventoServico $eventoServico)
    {
        $validated = $request->validate([
            'evento_id' => 'required',
            'descricao' => 'required',
            'valor' => 'required',
        ]);

        $eventoServico->update($validated);

        return redirect()->back();
    }

    public function destroy(EventoServico $eventoServico)
    {
        $eventoServico->delete();

        return redirect()->back();
    }
}
