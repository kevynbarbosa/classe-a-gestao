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
use App\Models\Artista;
use App\Models\Cidade;
use App\Models\Contratante;
use App\Models\Vendedor;
use App\Services\CidadeService;
use App\Services\EventoHistoricoService;
use App\Services\GeracaoModeloService;
use Illuminate\Support\Facades\DB;

class EventoWorkflowController extends Controller
{
    public function show(Evento $evento)
    {
        $evento->load(['artista', 'contratante', 'vendedor', 'cidade', 'historico', 'observacoes', 'observacoes.user', 'servicos']);

        return Inertia::render('EventoWorkflow/Index', [
            'evento' => $evento,
            'cidades' => CidadeService::cacheCidades(),
            'artistas' => Artista::all(),
            'vendedores' => Vendedor::all(),
            'evento_status_enum' => EventoStatusEnum::options()
        ]);
    }

    public function enviarFormulario(Request $request, Evento $evento)
    {
        $validatedData = $request->validate([
            'nome' => ['required'],
            'email_contratante' => ['required', 'email'],
        ]);

        try {

            $evento->email_formulario = $validatedData['email_contratante'];
            $evento->token_formulario = Str::uuid();
            try {
                Mail::to($validatedData['email_contratante'])->send(new FormularioContratanteMail($evento, $request->nome));
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
                'cidades' => CidadeService::cacheCidades(),
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
            'evento_duracao' => ['required'],
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
            'observacoes' => ['nullable'],
        ]);

        $contratante = Contratante::where('cpf_cnpj', $request->cpf_cnpj)->first();

        $contratanteFields = ['artista_pretendido', 'valor_combinado', 'evento_cidade_id', 'evento_recinto', 'evento_duracao', 'observacoes'];
        if ($contratante) {
            $contratante->update($request->except($contratanteFields));
        } else {
            $data = $request->except($contratanteFields);
            $data['tipo_pessoa'] = $data['cpf_cnpj'] > 11 ? 'pj' : 'pf';
            $contratante = Contratante::create($data);
        }

        if (empty($contratante)) throw new \Exception('Erro ao salvar contratante');

        $evento->contratante_id = $contratante->id;
        $evento->valor = $validatedData['valor_combinado'];
        $evento->cidade_id = $validatedData['evento_cidade_id'];
        $evento->recinto = $validatedData['evento_recinto'];
        $evento->artista_pretendido = $validatedData['artista_pretendido'];
        $evento->duracao = $validatedData['evento_duracao'];
        $evento->observacoes_contratante = $validatedData['observacoes'];
        $evento->save();

        if (!$evento->status == EventoStatusEnum::FORMULARIO_ENVIADO) {
            return 'expirado';
        };

        EventoHistoricoService::gerarHistorico($evento, EventoStatusEnum::PENDENTE_PROPOSTA);

        return back();
    }

    public function gerarProposta(Request $request, Evento $evento)
    {
        $request->validate([
            'evento_artista_id' => ['required'],
            'evento_vendedor_id' => ['required'],
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

        DB::beginTransaction();
        $contratante = $evento->contratante;
        $contratante->update($request->except(
            [
                'evento_artista_id',
                'evento_vendedor_id',
                'valor_combinado',
                'evento_cidade_id',
                'evento_recinto',
                'evento_duracao'
            ]
        ));

        $evento->artista_id = $request->evento_artista_id;
        $evento->vendedor_id = $request->evento_vendedor_id;
        $evento->valor = $request->valor_combinado;
        $evento->cidade_id = $request->evento_cidade_id;
        $evento->recinto = $request->evento_recinto;
        $evento->duracao = $request->evento_duracao;
        $evento->save();
        DB::commit();

        $geracaoModeloService = new GeracaoModeloService($evento);
        $geracaoModeloService->gerarProposta();

        EventoHistoricoService::gerarHistorico($evento, EventoStatusEnum::PROPOSTA_GERADA);

        return back();
    }

    public function editarProposta(Request $request, Evento $evento)
    {
        EventoHistoricoService::gerarHistorico($evento, EventoStatusEnum::PENDENTE_PROPOSTA);

        return back();
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
