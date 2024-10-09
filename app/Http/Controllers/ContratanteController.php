<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommonResource;
use App\Models\Contratante;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\QueryBuilder\QueryBuilder;

class ContratanteController extends Controller
{
    public function index()
    {
        $perPage = $request->perPage ?? 10;

        $contratante = QueryBuilder::for(Contratante::class)
            ->allowedFilters(['id', /*'other_fields...'*/])
            ->allowedSorts(['id', /*'other_fields...'*/])
            ->paginate($perPage);

        return Inertia::render('Contratante/Index', ['contratante' => CommonResource::collection($contratante)]);
    }

    public function create()
    {
        return Inertia::render('Contratante/Form');
    }

    public function store(Request $request)
    {
        Contratante::create($request->validate([
            // 'field_1' => ['required'],
        ]));

        return redirect()->back();
    }

    public function show(Contratante $contratante)
    {
        //
    }

    public function edit(Contratante $contratante)
    {
        return Inertia::render('Contratante/Form');
    }

    public function update(Request $request, Contratante $contratante)
    {
        $contratante->update($request->validate([
            // 'field_1' => ['required'],
        ]));

        return redirect()->back();
    }

    public function destroy(Contratante $contratante)
    {
        //
    }
}
