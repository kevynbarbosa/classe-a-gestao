<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Evento;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Enums\EventoStatusEnum;
use Illuminate\Support\Facades\Mail;
use App\Mail\FormularioContratanteMail;
use App\Mail\PropostaContratanteMail;
use App\Models\Cidade;
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
            try {
                Mail::to($validatedData['email_contratante'])->send(new FormularioContratanteMail($evento));
            } catch (\Throwable $th) {
                throw $th;
            }
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
                'cidades' => Cidade::all(),
                'contratante' => $evento->contratante
            ]);
        }

        return Inertia::render('EventoWorkflow/FormularioConcluido',);
    }

    public function salvarFormulario(Request $request, Evento $evento)
    {

        $validatedData = $request->validate([
            'artista_pretendido' => ['required'],
            'valor_combinado' => ['required'],
            'evento_cidade_id' => ['required'],
            'evento_recinto' => ['required'],
            'nome_completo' => ['required'],
            'cpf_cnpj' => ['required'],
            'cep' => ['required'],
            'endereco' => ['required'],
            'numero' => ['required'],
            'complemento' => ['nullable'],
            'bairro' => ['required'],
            'cidade_id' => ['required'],
            'representante_legal_nome' => ['required'],
            'representante_legal_cpf' => ['required'],
            'representante_legal_rg' => ['required'],
            'representante_legal_cep' => ['required'],
            'representante_legal_endereco' => ['required'],
            'representante_legal_numero' => ['required'],
            'representante_legal_complemento' => ['nullable'],
            'representante_legal_bairro' => ['required'],
            'representante_legal_cidade_id' => ['required'],
            'representante_legal_telefone' => ['required'],
        ]);

        $contratante = $evento->contratante;
        $contratante->update($request->except('artista_pretendido', 'valor_combinado', 'evento_cidade_id', 'evento_recinto'));

        $evento->valor = $validatedData['valor_combinado'];
        $evento->cidade_id = $validatedData['evento_cidade_id'];
        $evento->recinto = $validatedData['evento_recinto'];
        $evento->save();

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

        EventoHistoricoService::gerarHistorico($evento, EventoStatusEnum::PENDENTE_NF);

        return redirect()->back();
    }
}
