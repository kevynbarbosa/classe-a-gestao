<?php

namespace App\Http\Controllers;

use App\Models\Contratante;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContratanteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Contratantes/Index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Contratantes/Form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Contratante $contratante)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contratante $contratante)
    {
        return Inertia::render('Contratantes/Form');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contratante $contratante)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contratante $contratante)
    {
        //
    }
}
