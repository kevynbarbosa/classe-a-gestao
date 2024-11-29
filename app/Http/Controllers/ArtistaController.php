<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommonResource;
use App\Models\Artista;
use App\Models\Cidade;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\QueryBuilder\QueryBuilder;

class ArtistaController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->perPage ?? 10;

        $artistas = QueryBuilder::for(Artista::class)
            ->allowedFilters(['id', 'nome'])
            ->allowedSorts(['id', 'nome'])
            ->paginate($perPage);

        return Inertia::render('Artista/Index', ['artistas' => CommonResource::collection($artistas)]);
    }

    public function create()
    {
        return Inertia::render('Artista/Form', ['cidades' => Cidade::all()]);
    }

    public function store(Request $request)
    {
        Artista::create($request->validate([
            'nome' => ['required', 'max:50'],
            'razao_social' => ['required'],
            'cnpj' => ['required'],
            'email' => ['required', 'email'],
            'telefone' => ['required'],
            'endereco' => ['required'],
            'numero' => ['required'],
            'complemento' => ['required'],
            'bairro' => ['required'],
            'cep' => ['required'],
            'cidade_id' => ['required'],
            'representante_legal_nome' => ['required'],
            'representante_legal_cpf' => ['required'],
            'representante_legal_rg' => ['required'],
            'representante_legal_email' => ['required'],
        ]));

        return redirect()->back();
    }

    public function edit(Artista $artista)
    {
        return Inertia::render(
            'Artista/Form',
            [
                'artista' => $artista,
                'updating' => true,
                'cidades' => Cidade::all()
            ]
        );
    }

    public function update(Request $request, Artista $artista)
    {
        $artista->update($request->validate([
            'nome' => ['required', 'max:50'],
            'razao_social' => ['required'],
            'cnpj' => ['required'],
            'email' => ['required', 'email'],
            'telefone' => ['required'],
            'endereco' => ['required'],
            'numero' => ['required'],
            'complemento' => ['required'],
            'bairro' => ['required'],
            'cep' => ['required'],
            'cidade_id' => ['required'],
            'representante_legal_nome' => ['required'],
            'representante_legal_cpf' => ['required'],
            'representante_legal_rg' => ['required'],
            'representante_legal_email' => ['required'],
        ]));

        return redirect()->back();
    }

    public function delete() {}
}
