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

        // dd($request->filters);

        $artistas = QueryBuilder::for(Artista::class)
            ->allowedFilters(['id', 'nome'])
            ->allowedSorts(['id', 'nome'])
            ->paginate($perPage);

        // $artistas = Artista::query();
        // if ($request->sortField) {
        //     $order = $request->sortOrder == 1 ? 'desc' : 'asc';
        //     $artistas->orderBy($request->sortField, $order);
        // }

        return Inertia::render('Artista/Index', ['artistas' => CommonResource::collection($artistas)]);
    }

    public function create()
    {
        return Inertia::render('Artista/Form');
    }

    public function store(Request $request)
    {
        $post = new Artista($request->all());
        $post->save();
        return redirect()->route('artistas.index');
    }

    public function update(Artista $artista)
    {
        return Inertia::render('Artista/Form', ['artista' => $artista, 'updating' => true]);
    }

    public function delete() {}
}
