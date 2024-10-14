<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommonResource;
use App\Models\Vendedor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\QueryBuilder\QueryBuilder;

class VendedorController extends Controller
{
    public function index()
    {
        $perPage = $request->perPage ?? 10;

        $vendedores = QueryBuilder::for(Vendedor::class)
            ->allowedFilters(['id', 'cpf_cnpj', 'rg', 'nome_completo'])
            ->allowedSorts(['id', 'cpf_cnpj', 'rg', 'nome_completo', 'data_nascimento'])
            ->paginate($perPage);

        return Inertia::render('Vendedor/Index', ['vendedores' => CommonResource::collection($vendedores)]);
    }

    public function create()
    {
        return Inertia::render('Vendedor/Form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipo_pessoa' => ['required'],
            'cpf_cnpj' => ['required'],
            'rg' => ['nullable'],
            'nome_completo' => ['required'],
            'data_nascimento' => ['required', 'date'],
            'foto_path' => ['nullable'],
        ]);

        $validated['data_nascimento'] = Carbon::parse($validated['data_nascimento'])->format('Y-m-d');

        Vendedor::create($validated);

        return redirect()->back();
    }

    public function show(Vendedor $vendedor)
    {
        //
    }

    public function edit(Vendedor $vendedor)
    {
        return Inertia::render('Vendedor/Form', ['vendedor' => $vendedor, 'updating' => true]);
    }

    public function update(Request $request, Vendedor $vendedor)
    {
        $validated = $request->validate([
            'tipo_pessoa' => ['required'],
            'cpf_cnpj' => ['required'],
            'rg' => ['nullable'],
            'nome_completo' => ['required'],
            'data_nascimento' => ['required', 'date'],
            'foto_path' => ['nullable'],
        ]);

        $validated['data_nascimento'] = Carbon::parse($validated['data_nascimento'])->format('Y-m-d');

        $vendedor->update($validated);

        return redirect()->back();
    }

    public function destroy(Vendedor $vendedor)
    {
        //
    }
}
