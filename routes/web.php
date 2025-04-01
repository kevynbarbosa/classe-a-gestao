<?php

use App\Http\Controllers\ArtistaController;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\ContratanteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentoInternoCategoriaController;
use App\Http\Controllers\DocumentoInternoController;
use App\Http\Controllers\DownloadModelosController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\EventoObservacaoController;
use App\Http\Controllers\EventoServicoController;
use App\Http\Controllers\EventoWorkflowController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VendedorController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    // return redirect('/dashboard');
    return view('landing_page');
});

Route::get('/teste', function () {

    Storage::delete('documentos_internos/5NU3E4H5vI6nYeCkIhhoDi1cOKk9dV3jpzTbsxS5.txt');
    return;
    // dd(EventoStatusEnum::options());

    // return Inertia::render('Teste', [
    //     // 'canLogin' => Route::has('login'),
    //     // 'canRegister' => Route::has('register'),
    //     'laravelVersion' => Application::VERSION,
    //     'phpVersion' => PHP_VERSION,
    //     'cidades' => CidadeService::cacheCidades()
    // ]);
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', /* SimulateRealNetwork::class */])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('artistas', ArtistaController::class);
    Route::get('/calendario/evento-detalhes/{evento}', [CalendarioController::class, 'eventoDetalhes']);
    Route::resource('calendario', CalendarioController::class);
    Route::resource('eventos', EventoController::class);
    Route::resource('evento-observacoes', EventoObservacaoController::class)->parameters([
        'evento-observacoes' => 'eventoObservacao'
    ]);
    Route::prefix('eventos/{evento}')->group(function () {
        Route::resource('evento-servicos', EventoServicoController::class);
    });
    Route::resource('vendedores', VendedorController::class)->parameters([
        'vendedores' => 'vendedor'
    ]);
    Route::resource('contratantes', ContratanteController::class);
    Route::get('documentos-internos/download/{documento}', [DocumentoInternoController::class, 'download'])->name('documentos-internos.download');
    Route::get('documentos-internos/selecionarLoteDownload/{evento}', [DocumentoInternoController::class, 'selecionarLoteDownload'])->name('documentos-internos.selecionar-lote-download');
    Route::get('documentos-internos/loteDownload', [DocumentoInternoController::class, 'loteDownload'])->name('documentos-internos.lote-download');
    Route::resource('documentos-internos', DocumentoInternoController::class)->parameters([
        'documentos-internos' => 'documento'
    ]);
    Route::resource('documentos-internos-categorias', DocumentoInternoCategoriaController::class);
});

Route::controller(EventoWorkflowController::class)->name('evento-workflow.')->group(function () {
    Route::middleware(['auth'])->group(function () {
        Route::get('evento-workflow/{evento}', 'show')->name('show');
        Route::post('evento-workflow/{evento}/enviar-formulario', 'enviarFormulario')->name('enviar-formulario-contratante');
        Route::post('evento-workflow/{evento}/gerar-proposta', 'gerarProposta')->name('gerar-proposta');
        Route::post('evento-workflow/{evento}/editar-proposta', 'editarProposta')->name('editar-proposta');
        Route::get('evento-workflow/{evento}/confirmar-proposta-email', 'confirmarPropostaEmail')->name('confirmar-proposta-email');
        Route::post('evento-workflow/{evento}/enviar-proposta-email', 'enviarPropostaEmail')->name('enviar-proposta-email');
    });
    Route::get('contratante-formulario', 'showFormularioAberto')->name('contratante-formulario-aberto');
    Route::post('contratante-formulario/salvar-formulario-aberto', 'salvarFormularioAberto')->name('salvar-contratante-formulario-aberto');
});


Route::get('download-modelo/{evento}/{tipo}', [DownloadModelosController::class, 'downloadDocumentoGerado'])->name('download-modelo.gerado');
// Route::controller(DownloadModelosController::class)->name('download-modelo.')->group(function () {
//     Route::middleware(['auth'])->group(function () {
//         Route::get('download-modelo/{evento}/pdf-proposta', 'downloadPdfProposta')->name('pdf-proposta');
//         Route::get('download-modelo/{evento}/word-proposta', 'downloadWordProposta')->name('word-proposta');
//         Route::get('download-modelo/{evento}/pdf-declaracao', 'downloadPdfDeclaracao')->name('pdf-declaracao');
//         Route::get('download-modelo/{evento}/word-declaracao', 'downloadWordDeclaracao')->name('word-declaracao');
//         Route::get('download-modelo/{evento}/pdf-declaracao-economica', 'downloadPdfDeclaracaoEconomica')->name('pdf-declaracao-economica');
//         Route::get('download-modelo/{evento}/word-declaracao-economica', 'downloadWordDeclaracaoEconomica')->name('word-declaracao-economica');
//     });
// });


require __DIR__ . '/auth.php';
