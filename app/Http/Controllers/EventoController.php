<?php

namespace App\Http\Controllers;

use App\Enums\EventoStatusEnum;
use App\Http\Resources\CommonResource;
use App\Models\Artista;
use App\Models\Cidade;
use App\Models\Contratante;
use App\Models\Evento;
use App\Models\Vendedor;
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
            ->with(['artista', 'contratante'])
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
            'cidades' => Cidade::all(),
            'artistas' => Artista::all(),
            'vendedores' => Vendedor::all(),
            'contratantes' => Contratante::all()
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'artista_id' => ['required'],
            'contratante_id' => ['required'],
            'vendedor_id' => ['required'],
            'data_hora' => ['required', 'date'],
            'evento_internacional' => ['required', 'boolean'],
            'cidade_id' => ['required_if:evento_internacional,0'],
            'cidade_exterior' => ['required_if:evento_internacional,1'],
            'recinto' => ['required'],
            'duracao' => ['required', 'date_format:H:i'],
            'valor' => ['required', 'decimal'],
        ]);

        $validatedData['data_hora'] = Carbon::parse($validatedData['data_hora']);

        $evento = Evento::create($validatedData);

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
            'cidades' => Cidade::all(),
            'artistas' => Artista::all(),
            'vendedores' => Vendedor::all(),
            'contratantes' => Contratante::all()
        ]);
    }

    public function update(Request $request, Evento $evento)
    {
        $validatedData = $request->validate([
            'artista_id' => ['required'],
            'contratante_id' => ['required'],
            'vendedor_id' => ['required'],
            'data_hora' => ['required', 'date'],
            'evento_internacional' => ['required', 'boolean'],
            'cidade_id' => ['required_if:evento_internacional,0'],
            'cidade_exterior' => ['required_if:evento_internacional,1'],
            'recinto' => ['required'],
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
