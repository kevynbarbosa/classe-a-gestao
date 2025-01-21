<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\EventoServico;
use Illuminate\Http\Request;

class EventoServicoController extends Controller
{
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

    public function destroy(EventoServico $eventoServico)
    {
        $eventoServico->delete();

        return redirect()->back();
    }
}
