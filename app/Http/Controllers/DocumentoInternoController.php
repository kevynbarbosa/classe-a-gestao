<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommonResource;
use App\Models\Artista;
use App\Models\DocumentoInterno;
use App\Models\DocumentoInternoCategoria;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use League\CommonMark\Node\Block\Document;

class DocumentoInternoController extends Controller
{
    public function index()
    {
        $artistas = Artista::all();
        $categorias = DocumentoInternoCategoria::orderBy('nome')->get();
        $documentos = DocumentoInterno::with('artista')->orderBy('artista_id')->get();

        return Inertia::render('DocumentoInterno/Index', [
            'artistas' => $artistas,
            'categorias' => $categorias,
            'documentos' => $documentos
        ]);
    }

    public function create()
    {
        return Inertia::render('DocumentoInterno/UploadDocumento', [
            'artistas' => Artista::all(),
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

        // Excluir o arquivo antigo se existir
        if ($request->artista_id) {
            $documentosExcluir = DocumentoInterno::where('artista_id', $request->artista_id)->where('categoria_id', $request->categoria_id)->get();
        } else {
            $documentosExcluir = DocumentoInterno::whereNull('artista_id')->where('categoria_id', $request->categoria_id)->get();
        }

        $documentosExcluir->each(function ($documento) {
            Storage::delete($documento->path);
            $documento->delete();
        });

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
        $fileExtension = pathinfo($documento->path, PATHINFO_EXTENSION);
        $fileName = $documento->categoria->nome . ".$fileExtension";

        return response()->download(storage_path('app/') . $documento->path, $fileName);
    }
}
