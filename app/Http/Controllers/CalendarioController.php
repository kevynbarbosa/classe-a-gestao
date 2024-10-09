<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommonResource;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CalendarioController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Calendario/Index',);
    }
}
