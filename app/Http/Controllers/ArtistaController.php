<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommonResource;
use App\Models\Artista;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ArtistaController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->perPage ?? 10;

        $artistas = Artista::paginate($perPage);

        sleep(2);

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
