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
use App\Services\ContratanteService;
use App\Services\EventoHistoricoService;
use App\Services\GeracaoModeloService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

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
            // TODO: Correto seria enviar o email em uma fila
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

        return Inertia::render('EventoWorkflow/FormularioConcluido');
    }

    public function showFormularioAberto(Evento $evento)
    {
        return Inertia::render('EventoWorkflow/FormularioAberto', [
            'cidades' => CidadeService::cacheCidades(),
        ]);
    }

    public function salvarFormularioAberto(Request $request, Evento $evento, ContratanteService $contratanteService)
    {
        $validatedData = $request->validate([
            'tipo_pessoa' => ['required'],
            'artista_pretendido' => ['required'],
            'valor_combinado' => ['required'],
            'evento_cidade_id' => ['required'],
            'evento_recinto' => ['required'],
            'evento_duracao' => ['required'],
            'evento_data_hora' => ['required'],

            'nome_completo' => [Rule::requiredIf($request->tipo_pessoa != 'prefeitura')],
            'cpf_cnpj' => [Rule::requiredIf($request->tipo_pessoa != 'prefeitura')],
            'cep' => [Rule::requiredIf($request->tipo_pessoa != 'prefeitura')],
            'endereco' => [Rule::requiredIf($request->tipo_pessoa != 'prefeitura')],
            'numero' => [Rule::requiredIf($request->tipo_pessoa != 'prefeitura')],
            'complemento' => [Rule::requiredIf($request->tipo_pessoa != 'prefeitura')],
            'bairro' => [Rule::requiredIf($request->tipo_pessoa != 'prefeitura')],
            'cidade_id' => [Rule::requiredIf($request->tipo_pessoa != 'prefeitura')],
            'representante_legal_nome' => [Rule::requiredIf($request->tipo_pessoa != 'prefeitura')],
            'representante_legal_cpf' => [Rule::requiredIf($request->tipo_pessoa != 'prefeitura')],
            'representante_legal_rg' => [Rule::requiredIf($request->tipo_pessoa != 'prefeitura')],
            'representante_legal_cep' => [Rule::requiredIf($request->tipo_pessoa != 'prefeitura')],
            'representante_legal_endereco' => [Rule::requiredIf($request->tipo_pessoa != 'prefeitura')],
            'representante_legal_numero' => [Rule::requiredIf($request->tipo_pessoa != 'prefeitura')],
            'representante_legal_complemento' => ['nullable'],
            'representante_legal_bairro' => [Rule::requiredIf($request->tipo_pessoa != 'prefeitura')],
            'representante_legal_cidade_id' => [Rule::requiredIf($request->tipo_pessoa != 'prefeitura')],
            'representante_legal_telefone' => [Rule::requiredIf($request->tipo_pessoa != 'prefeitura')],
            'observacoes' => ['nullable'],
        ]);

        $contratante = $contratanteService->obterOuCriarContratante($request);

        $evento = new Evento;
        $evento->contratante_id = $contratante->id;
        $evento->valor = $validatedData['valor_combinado'];
        $evento->cidade_id = $validatedData['evento_cidade_id'];
        $evento->recinto = $validatedData['evento_recinto'];
        $evento->artista_pretendido = $validatedData['artista_pretendido'];
        $evento->data_hora = $validatedData['evento_data_hora'] ? Carbon::parse($validatedData['evento_data_hora']) : null;
        $evento->duracao = $validatedData['evento_duracao'];
        $evento->observacoes_contratante = $validatedData['observacoes'];
        $evento->save();

        EventoHistoricoService::gerarHistorico($evento, EventoStatusEnum::PENDENTE_PROPOSTA);

        return Inertia::render('EventoWorkflow/FormularioConcluido');
    }

    public function salvarFormulario(Request $request, Evento $evento)
    {
        $validatedData = $request->validate([
            'artista_pretendido' => ['required'],
            'valor_combinado' => ['required'],
            'evento_cidade_id' => ['required'],
            'evento_recinto' => ['required'],
            'evento_duracao' => ['required'],

            'nome_completo' => [Rule::requiredIf($evento->contratante->tipo_pessoa != 'prefeitura')],
            'cpf_cnpj' => [Rule::requiredIf($evento->contratante->tipo_pessoa != 'prefeitura')],
            'cep' => [Rule::requiredIf($evento->contratante->tipo_pessoa != 'prefeitura')],
            'endereco' => [Rule::requiredIf($evento->contratante->tipo_pessoa != 'prefeitura')],
            'numero' => [Rule::requiredIf($evento->contratante->tipo_pessoa != 'prefeitura')],
            'complemento' => [Rule::requiredIf($evento->contratante->tipo_pessoa != 'prefeitura')],
            'bairro' => [Rule::requiredIf($evento->contratante->tipo_pessoa != 'prefeitura')],
            'cidade_id' => [Rule::requiredIf($evento->contratante->tipo_pessoa != 'prefeitura')],
            'representante_legal_nome' => [Rule::requiredIf($evento->contratante->tipo_pessoa != 'prefeitura')],
            'representante_legal_cpf' => [Rule::requiredIf($evento->contratante->tipo_pessoa != 'prefeitura')],
            'representante_legal_rg' => [Rule::requiredIf($evento->contratante->tipo_pessoa != 'prefeitura')],
            'representante_legal_cep' => [Rule::requiredIf($evento->contratante->tipo_pessoa != 'prefeitura')],
            'representante_legal_endereco' => [Rule::requiredIf($evento->contratante->tipo_pessoa != 'prefeitura')],
            'representante_legal_numero' => [Rule::requiredIf($evento->contratante->tipo_pessoa != 'prefeitura')],
            'representante_legal_complemento' => ['nullable'],
            'representante_legal_bairro' => [Rule::requiredIf($evento->contratante->tipo_pessoa != 'prefeitura')],
            'representante_legal_cidade_id' => [Rule::requiredIf($evento->contratante->tipo_pessoa != 'prefeitura')],
            'representante_legal_telefone' => [Rule::requiredIf($evento->contratante->tipo_pessoa != 'prefeitura')],
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

            'cpf_cnpj' => [Rule::requiredIf($evento->contratante->tipo_pessoa != 'prefeitura')],
            'cep' => [Rule::requiredIf($evento->contratante->tipo_pessoa != 'prefeitura')],
            'endereco' => [Rule::requiredIf($evento->contratante->tipo_pessoa != 'prefeitura')],
            'numero' => [Rule::requiredIf($evento->contratante->tipo_pessoa != 'prefeitura')],
            'complemento' => ['nullable'],
            'bairro' => [Rule::requiredIf($evento->contratante->tipo_pessoa != 'prefeitura')],
            'cidade_id' => [Rule::requiredIf($evento->contratante->tipo_pessoa != 'prefeitura')],
            'representante_legal_nome' => [Rule::requiredIf($evento->contratante->tipo_pessoa != 'prefeitura')],
            'representante_legal_cpf' => [Rule::requiredIf($evento->contratante->tipo_pessoa != 'prefeitura')],
            'representante_legal_rg' => [Rule::requiredIf($evento->contratante->tipo_pessoa != 'prefeitura')],
            'representante_legal_cep' => [Rule::requiredIf($evento->contratante->tipo_pessoa != 'prefeitura')],
            'representante_legal_endereco' => [Rule::requiredIf($evento->contratante->tipo_pessoa != 'prefeitura')],
            'representante_legal_numero' => [Rule::requiredIf($evento->contratante->tipo_pessoa != 'prefeitura')],
            'representante_legal_complemento' => ['nullable'],
            'representante_legal_bairro' => [Rule::requiredIf($evento->contratante->tipo_pessoa != 'prefeitura')],
            'representante_legal_cidade_id' => [Rule::requiredIf($evento->contratante->tipo_pessoa != 'prefeitura')],
            'representante_legal_telefone' => [Rule::requiredIf($evento->contratante->tipo_pessoa != 'prefeitura')],
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
        // TODO: Correto seria enviar o email em uma fila
        Mail::to($evento->email_formulario)->send(new PropostaContratanteMail($evento));

        EventoHistoricoService::gerarHistorico($evento, EventoStatusEnum::PENDENTE_NF);

        return redirect()->back();
    }
}
