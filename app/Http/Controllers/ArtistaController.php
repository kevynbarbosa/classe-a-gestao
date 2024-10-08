<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommonResource;
use App\Models\Artista;
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
        return Inertia::render('Artista/Form');
    }

    public function store(Request $request)
    {
        Artista::create($request->validate([
            'nome' => ['required', 'max:50'],
        ]));

        return redirect()->route('artistas.index');
    }

    public function edit(Artista $artista)
    {
        return Inertia::render('Artista/Form', ['artista' => $artista, 'updating' => true]);
    }

    public function update(Request $request, Artista $artista)
    {
        $artista->update($request->validate([
            'nome' => ['required', 'max:50'],
        ]));

        return redirect()->route('artistas.index');
    }

    public function delete() {}
}
