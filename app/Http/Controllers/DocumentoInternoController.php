<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommonResource;
use App\Models\Artista;
use App\Models\DocumentoInterno;
use App\Models\DocumentoInternoCategoria;
use Carbon\Carbon;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Http\Request;
use Inertia\Inertia;
use League\CommonMark\Node\Block\Document;

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
            'data_validade' => ['required', 'date'],
            'arquivo' => ['required', 'file'],
        ]);

        $nome_original = $request->arquivo->getClientOriginalName();
        $path = $request->arquivo->store('documentos_internos');

        $data = array_merge($request->except(['arquivo']), [
            'data_validade' => Carbon::parse($request->data_validade)->format('Y-m-d'),
            'nome_original' => $nome_original,
            'path' => $path
        ]);

        $documento = DocumentoInterno::create($data);

        return redirect()->back();
    }

    public function download(DocumentoInterno $documento)
    {
        return response()->download(storage_path('app/') . $documento->path);
    }
}
