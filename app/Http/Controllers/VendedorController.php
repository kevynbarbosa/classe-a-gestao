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

        $vendedor = QueryBuilder::for(Vendedor::class)
            ->allowedFilters(['id', /*'other_fields...'*/])
            ->allowedSorts(['id', /*'other_fields...'*/])
            ->paginate($perPage);

        return Inertia::render('Vendedor/Index', ['vendedor' => CommonResource::collection($vendedor)]);
    }

    public function create()
    {
        return Inertia::render('Vendedor/Form');
    }

    public function store(Request $request)
    {
        Vendedor::create($request->validate([
            // 'field_1' => ['required'],
        ]));

        return redirect()->back();
    }

    public function show(Vendedor $vendedor)
    {
        //
    }

    public function edit(Vendedor $vendedor)
    {
        return Inertia::render('Vendedor/Form');
    }

    public function update(Request $request, Vendedor $vendedor)
    {
        $vendedor->update($request->validate([
            // 'field_1' => ['required'],
        ]));

        return redirect()->back();
    }

    public function destroy(Vendedor $vendedor)
    {
        //
    }
}
