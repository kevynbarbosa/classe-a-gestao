<?php

namespace App\Http\Controllers;

use App\Models\DocumentoInternoCategoria;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DocumentoInternoCategoriaController extends Controller
{
    public function create()
    {
        return Inertia::render('DocumentoInterno/NovaCategoria');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => ['required', 'max:255']
        ]);

        DocumentoInternoCategoria::create($validated);

        return redirect()->back();
    }
}
