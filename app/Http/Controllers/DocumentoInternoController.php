<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommonResource;
use App\Models\Artista;
use App\Models\DocumentoInterno;
use App\Models\DocumentoInternoCategoria;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DocumentoInternoController extends Controller
{
    public function index()
    {
        $artistas = Artista::all();
        $categorias = DocumentoInternoCategoria::orderBy('nome')->get();
        $documentos = DocumentoInterno::all();

        return Inertia::render('DocumentoInterno/Index', [
            'artistas' => $artistas,
            'categorias' => $categorias,
            'documentos' => $documentos
            // 'documentos' => CommonResource::collection($documentos)
        ]);
    }

    public function create()
    {
        return Inertia::render('DocumentoInterno/UploadDocumento', [
            'categorias' => DocumentoInternoCategoria::all()
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'artista_id' => ['nullable'],
            'categoria_id' => ['required'],
            'arquivo' => ['required', 'file'],
        ]);

        $documento = DocumentoInterno::create($validatedData);

        return redirect()->back();
    }
}
