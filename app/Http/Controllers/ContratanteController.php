<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommonResource;
use App\Models\Contratante;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\QueryBuilder\QueryBuilder;

class ContratanteController extends Controller
{
    public function index()
    {
        $perPage = $request->perPage ?? 10;

        $contratantes = QueryBuilder::for(Contratante::class)
            ->allowedFilters(['id', 'cpf_cnpj', 'rg', 'nome_completo'])
            ->allowedSorts(['id', 'cpf_cnpj', 'rg', 'nome_completo'])
            ->paginate($perPage);

        return Inertia::render('Contratante/Index', ['contratantes' => CommonResource::collection($contratantes)]);
    }

    public function create()
    {
        return Inertia::render('Contratante/Form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipo_pessoa' => ['required'],
            'cpf_cnpj' => ['nullable'],
            'rg' => ['nullable'],
            'nome_completo' => ['required'],
            'foto_path' => ['nullable'],
        ]);

        Contratante::create($validated);

        return redirect()->back();
    }

    public function show(Contratante $contratante)
    {
        //
    }

    public function edit(Contratante $contratante)
    {
        return Inertia::render('Contratante/Form', ['contratante' => $contratante, 'updating' => true]);
    }

    public function update(Request $request, Contratante $contratante)
    {

        $validated = $request->validate([
            'tipo_pessoa' => ['required'],
            'cpf_cnpj' => ['nullable'],
            'rg' => ['nullable'],
            'nome_completo' => ['required'],
            'foto_path' => ['nullable'],
        ]);

        $contratante->update($validated);

        return redirect()->back();
    }

    public function destroy(Contratante $contratante)
    {
        //
    }
}
