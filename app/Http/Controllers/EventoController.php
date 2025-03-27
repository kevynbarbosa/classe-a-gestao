<?php

namespace App\Http\Controllers;

use App\Enums\EventoStatusEnum;
use App\Http\Resources\CommonResource;
use App\Models\Artista;
use App\Models\Cidade;
use App\Models\Contratante;
use App\Models\Evento;
use App\Models\Vendedor;
use App\Services\CidadeService;
use App\Services\EventoHistoricoService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\QueryBuilder\QueryBuilder;

class EventoController extends Controller
{
    public function index()
    {
        $perPage = $request->perPage ?? 10;

        $eventos = QueryBuilder::for(Evento::class)
            ->allowedFilters(['id', /*'other_fields...'*/])
            ->allowedSorts(['id', 'artista.nome'])
            ->with(['artista', 'contratante', 'cidade'])
            ->paginate($perPage);

        return Inertia::render(
            'Evento/Index',
            [
                'eventos' => CommonResource::collection($eventos),
                'evento_status_enum' => EventoStatusEnum::options()
            ]
        );
    }

    public function create()
    {
        return Inertia::render('Evento/Form', [
            'cidades' => CidadeService::cacheCidades(),
            'artistas' => Artista::all(),
            'vendedores' => Vendedor::all(),
            'contratantes' => Contratante::all()
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'artista_id' => ['nullable'],
            'contratante_id' => ['required'],
            'vendedor_id' => ['nullable'],
            'data_hora' => ['nullable', 'date'],
            'evento_internacional' => ['nullable', 'boolean'],
            'cidade_id' => ['nullable'],
            'cidade_exterior' => ['nullable'],
            'recinto' => ['nullable'],
            'duracao' => ['nullable', 'numeric'],
            'valor' => ['nullable'],
        ]);

        if ($validatedData['data_hora']) {
            $validatedData['data_hora'] = Carbon::parse($validatedData['data_hora']);
        }

        $evento = Evento::create($validatedData);

        EventoHistoricoService::gerarHistorico($evento, EventoStatusEnum::PENDENTE_PROPOSTA);

        return to_route('evento-workflow.show', ['evento' => $evento->id]);
    }

    public function show(Evento $evento)
    {
        //
    }

    public function edit(Evento $evento)
    {
        return Inertia::render('Evento/Form', [
            'evento' => $evento,
            'updating' => true,
            'cidades' => CidadeService::cacheCidades(),
            'artistas' => Artista::all(),
            'vendedores' => Vendedor::all(),
            'contratantes' => Contratante::all()
        ]);
    }

    public function update(Request $request, Evento $evento)
    {
        $validatedData = $request->validate([
            'artista_id' => ['nullable'],
            'contratante_id' => ['required'],
            'vendedor_id' => ['nullable'],
            'data_hora' => ['nullable', 'date'],
            'evento_internacional' => ['nullable', 'boolean'],
            'cidade_id' => ['nullable'],
            'cidade_exterior' => ['nullable'],
            'recinto' => ['nullable'],
        ]);

        $validatedData['data_hora'] = Carbon::parse($validatedData['data_hora']);

        $evento->update($validatedData);

        return redirect()->back();
    }

    public function destroy(Evento $evento)
    {
        //
    }
}
