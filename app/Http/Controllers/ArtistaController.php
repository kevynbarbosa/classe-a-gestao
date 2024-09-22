<?php

namespace App\Http\Controllers;

use App\Models\Artista;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ArtistaController extends Controller
{
    public function index()
    {
        $artistas = Artista::all();
        return Inertia::render('Artista/Index', ['artistas' => $artistas]);
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
