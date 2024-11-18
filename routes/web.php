<?php

use App\Enums\EventoStatusEnum;
use App\Http\Controllers\ArtistaController;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\ContratanteController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\EventoWorkflowController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VendedorController;
use App\Http\Middleware\SimulateRealNetwork;
use App\Models\Cidade;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect('/dashboard');
    // return Inertia::render('Welcome', [
    //     'canLogin' => Route::has('login'),
    //     'canRegister' => Route::has('register'),
    //     'laravelVersion' => Application::VERSION,
    //     'phpVersion' => PHP_VERSION,
    // ]);
});

Route::get('/teste', function () {

    dd(EventoStatusEnum::options());

    return Inertia::render('Teste', [
        // 'canLogin' => Route::has('login'),
        // 'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'cidades' => Cidade::all()
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard',);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', /* SimulateRealNetwork::class */])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('artistas', ArtistaController::class);
    Route::get('/calendario/evento-detalhes/{evento}', [CalendarioController::class, 'eventoDetalhes']);
    Route::resource('calendario', CalendarioController::class);
    Route::resource('eventos', EventoController::class);
    Route::resource('vendedores', VendedorController::class)->parameters([
        'vendedores' => 'vendedor'
    ]);
    Route::resource('contratantes', ContratanteController::class);

    Route::get('evento-workflow/{evento}', [EventoWorkflowController::class, 'show'])->name('evento-workflow.show');
});

Route::get('contratante-formulario/{token}', [EventoWorkflowController::class, 'showFormulario'])->name('contratante-formulario');

require __DIR__ . '/auth.php';
