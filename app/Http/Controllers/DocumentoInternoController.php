<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommonResource;
use App\Models\Artista;
use App\Models\DocumentoInterno;
use App\Models\DocumentoInternoCategoria;
use App\Models\Evento;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use League\CommonMark\Node\Block\Document;
use ZipArchive;

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

    public function destroy(DocumentoInterno $documento)
    {
        Storage::delete($documento->path);
        $documento->delete();

        return redirect()->back();
    }

    public function download(DocumentoInterno $documento)
    {
        $fileExtension = pathinfo($documento->path, PATHINFO_EXTENSION);
        $fileName = $documento->categoria->nome . ".$fileExtension";

        return response()->download(storage_path('app/') . $documento->path, $fileName);
    }

    public function selecionarLoteDownload(Evento $evento)
    {
        $documentos = DocumentoInterno::where('artista_id', $evento->artista_id)->where('data_validade', '>=', now())->get();

        return Inertia::render('DocumentoInterno/DownloadLoteDocumentos', [
            'evento' => $evento,
            'documentos' => $documentos
        ]);
    }

    public function loteDownload(Request $request)
    {
        $documentos = DocumentoInterno::whereIn('id', $request->documento_ids)->get();

        $zipFileName = 'arquivos.zip';
        $zipPath = storage_path('app/' . $zipFileName);

        $zip = new ZipArchive;

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            foreach ($documentos as $documento) {
                $filePath = storage_path('app/' . $documento->path);
                if (file_exists($filePath)) {
                    $zip->addFile($filePath, basename($documento->nome_original));
                }
            }

            $zip->close();
        }

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }
}
