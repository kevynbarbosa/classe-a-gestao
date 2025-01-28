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
use App\Services\GeracaoModeloService;

class EventoWorkflowController extends Controller
{
    public function show(Evento $evento)
    {
        $evento->load(['artista', 'contratante', 'vendedor', 'cidade', 'historico', 'observacoes', 'observacoes.user', 'servicos']);

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
            Mail::to($validatedData['email_contratante'])->send(new FormularioContratanteMail($evento));
            $evento->save();
        } catch (\Throwable $th) {
            throw $th;
        }

        if (!$evento->formulario_enviado_em) $evento->formulario_enviado_em = now();
        $evento->save();

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
                'contratante' => $evento->contratante
            ]);
        }

        return Inertia::render('EventoWorkflow/FormularioConcluido',);
    }

    public function salvarFormulario(Request $request, Evento $evento)
    {
        $validatedData = $request->validate([
            'nome_completo' => ['required'],
            'cpf_cnpj' => ['required'],
            'rg' => ['required'],
        ]);

        $contratante = $evento->contratante;
        $contratante->update($validatedData);

        if (!$evento->status == EventoStatusEnum::FORMULARIO_ENVIADO) {
            return 'expirado';
        };

        EventoHistoricoService::gerarHistorico($evento, EventoStatusEnum::PENDENTE_PROPOSTA);

        return back();
    }

    public function gerarProposta(Request $request, Evento $evento)
    {
        $validatedData = $request->validate([
            // 'nome_completo' => ['required'],
            // 'cpf_cnpj' => ['required'],
            // 'rg' => ['required'],
            // 'atualizar_cadastro' => ['required', 'boolean'],
        ]);

        // if ($validatedData['atualizar_cadastro']) {
        //     $contratante = $evento->contratante;
        //     $contratante->update($validatedData);
        // }

        $geracaoModeloService = new GeracaoModeloService();
        $geracaoModeloService->gerarProposta($evento);

        EventoHistoricoService::gerarHistorico($evento, EventoStatusEnum::PROPOSTA_GERADA);

        return back();
    }

    public function editarProposta(Request $request, Evento $evento)
    {
        EventoHistoricoService::gerarHistorico($evento, EventoStatusEnum::PENDENTE_PROPOSTA);

        return back();
    }

    public function downloadPdf(Evento $evento)
    {
        $path = storage_path('/app/public/eventos/') . $evento->id . '/proposta.pdf';
        return response()->download($path, null, [
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
            'Expires' => 'Sat, 01 Jan 2000 00:00:00 GMT',
        ]);
    }

    public function downloadWord(Evento $evento)
    {
        $path = storage_path('/app/public/eventos/') . $evento->id . '/proposta.docx';
        return response()->download($path, null, [
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
            'Expires' => 'Sat, 01 Jan 2000 00:00:00 GMT',
        ]);
    }

    public function confirmarPropostaEmail(Evento $evento)
    {
        return Inertia::render('EventoWorkflow/Partials/ModalEnviarProposta', ['evento' => $evento]);
    }

    public function enviarPropostaEmail(Evento $evento)
    {
        Mail::to($evento->email_formulario)->send(new PropostaContratanteMail($evento));

        return redirect()->back();
    }
}
