<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommonResource;
use App\Models\Vendedor;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\QueryBuilder\QueryBuilder;

class VendedorController extends Controller
{
    public function index()
    {
        $perPage = $request->perPage ?? 10;

        $vendedores = QueryBuilder::for(Vendedor::class)
            ->allowedFilters(['id', /*'other_fields...'*/])
            ->allowedSorts(['id', /*'other_fields...'*/])
            ->paginate($perPage);

        return Inertia::render('Vendedor/Index', ['vendedores' => CommonResource::collection($vendedores)]);
    }

    public function create()
    {
        return Inertia::render('Vendedor/Form');
    }

    public function store(Request $request)
    {
        Vendedor::create($request->validate([
            'cpf' => ['required'],
            'rg' => ['required'],
            'nome_completo' => ['required'],
            'data_nascimento' => ['required'],
            'foto_path' => ['nullable'],
        ]));

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
        $vendedor->update($request->validate([
            'cpf' => ['required'],
            'rg' => ['required'],
            'nome_completo' => ['required'],
            'data_nascimento' => ['required'],
            'foto_path' => ['nullable'],
        ]));

        return redirect()->back();
    }

    public function destroy(Vendedor $vendedor)
    {
        //
    }
}
