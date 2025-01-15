<?php

namespace App\Http\Controllers;

use App\Models\EventoObservacao;
use Illuminate\Http\Request;

class EventoObservacaoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'evento_id' => 'required',
            'observacao' => 'required',
        ]);

        $eventoObservacao = EventoObservacao::create(
            array_merge(
                $request->all(),
                ['user_id' => $request->user()->id]
            )
        );

        return redirect()->back();
    }
}
