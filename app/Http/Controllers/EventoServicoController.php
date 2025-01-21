<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\EventoServico;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EventoServicoController extends Controller
{

    public function create()
    {
        return Inertia::render('EventoWorkflow/Partials/ServicoForm', []);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'evento_id' => 'required',
            'descricao' => 'required',
            'valor' => 'required',
        ]);

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

    public function update(Request $request, EventoServico $eventoServico)
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
