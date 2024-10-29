<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EventoWorkflowController extends Controller
{
    public function show(Evento $evento)
    {
        return Inertia::render('EventoWorkflow/Index', [
            'evento' => $evento
        ]);
    }
}
