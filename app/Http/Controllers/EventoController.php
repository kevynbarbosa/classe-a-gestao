<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommonResource;
use App\Models\Evento;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\QueryBuilder\QueryBuilder;

class EventoController extends Controller
{
    public function index()
    {
        $perPage = $request->perPage ?? 10;

        $evento = QueryBuilder::for(Evento::class)
            ->allowedFilters(['id', /*'other_fields...'*/])
            ->allowedSorts(['id', /*'other_fields...'*/])
            ->paginate($perPage);

        return Inertia::render('Evento/Index', ['evento' => CommonResource::collection($evento)]);
    }

    public function create()
    {
        return Inertia::render('Evento/Form');
    }

    public function store(Request $request)
    {
        Evento::create($request->validate([
            // 'field_1' => ['required'],
        ]));

        return redirect()->back();
    }

    public function show(Evento $evento)
    {
        //
    }

    public function edit(Evento $evento)
    {
        return Inertia::render('Evento/Form');
    }

    public function update(Request $request, Evento $evento)
    {
        $evento->update($request->validate([
            // 'field_1' => ['required'],
        ]));

        return redirect()->back();
    }

    public function destroy(Evento $evento)
    {
        //
    }
}
