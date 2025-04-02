<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\EventoPagamento;
use App\Services\GeracaoModeloService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventoPagamentoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'evento_id' => 'required',
            'data_pagamento' => ['required', 'date'],
            'valor' => 'required|numeric',
        ]);

        $dados = $request->all();
        $dados['data_pagamento'] = Carbon::parse($request->data_pagamento)->timezone('UTC')->toDateString();

        $eventoPagamento = EventoPagamento::create($dados);

        try {
            (new GeracaoModeloService(Evento::find($request->evento_id)))->gerarContrato();
        } catch (\Throwable $th) {
            // Handle exception if needed
        }

        return redirect()->back();
    }

    public function destroy(EventoPagamento $eventoPagamento)
    {
        $eventoPagamento->delete();

        try {
            (new GeracaoModeloService(Evento::find($eventoPagamento->evento_id)))->gerarContrato();
        } catch (\Throwable $th) {
            // Handle exception if needed
        }

        return redirect()->back();
    }
}
