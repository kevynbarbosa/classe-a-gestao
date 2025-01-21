<?php

use App\Enums\EventoStatusEnum;
use App\Http\Controllers\ArtistaController;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\ContratanteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentoInternoCategoriaController;
use App\Http\Controllers\DocumentoInternoController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\EventoObservacaoController;
use App\Http\Controllers\EventoServicoController;
use App\Http\Controllers\EventoWorkflowController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VendedorController;
use App\Http\Middleware\SimulateRealNetwork;
use App\Models\Cidade;
use App\Services\GeracaoModeloService;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/teste', function () {

    Storage::delete('documentos_internos/5NU3E4H5vI6nYeCkIhhoDi1cOKk9dV3jpzTbsxS5.txt');
    return;

    $modeloDocx = storage_path('app/modelos_proposta/MODELO_PROPOSTA.docx');
    $dados = [
        '{{ARTISTA_NOME}}' => '{{TOKEN_SUBSTITUIDO}}',
        '{{ARTISTA_RAZAO_SOCIAL}}' => '{{TOKEN_SUBSTITUIDO}}',
        '{{ARTISTA_CNPJ}}' => '{{TOKEN_SUBSTITUIDO}}',
        '{{ARTISTA_ENDERECO}}' => '{{TOKEN_SUBSTITUIDO}}',
        '{{ARTISTA_NUMERO}}' => '{{TOKEN_SUBSTITUIDO}}',
        '{{ARTISTA_COMPLEMENTO}}' => '{{TOKEN_SUBSTITUIDO}}',
        '{{ARTISTA_BAIRRO}}' => '{{TOKEN_SUBSTITUIDO}}',
        '{{ARTISTA_CIDADE}}' => '{{TOKEN_SUBSTITUIDO}}',
        '{{ARTISTA_CEP}}' => '{{TOKEN_SUBSTITUIDO}}',
        '{{ARTISTA_REPRESENTANTE_LEGAL_NOME}}' => '{{TOKEN_SUBSTITUIDO}}',
        '{{ARTISTA_REPRESENTANTE_LEGAL_CPF}}' => '{{TOKEN_SUBSTITUIDO}}',
        '{{ARTISTA_REPRESENTANTE_LEGAL_RG}}' => '{{TOKEN_SUBSTITUIDO}}',
        '{{EVENTO_CIDADE}}' => '{{TOKEN_SUBSTITUIDO}}',
        '{{EVENTO_DURACAO}}' => '{{TOKEN_SUBSTITUIDO}}',
        '{{EVENTO_DATA}}' => '{{TOKEN_SUBSTITUIDO}}',
        '{{EVENTO_RECINTO}}' => '{{TOKEN_SUBSTITUIDO}}',
        '{{EVENTO_CIDADE}}' => '{{TOKEN_SUBSTITUIDO}}',
        '{{EVENTO_VALOR}}' => '{{TOKEN_SUBSTITUIDO}}',
        '{{EVENTO_VALOR_EXTENSO}}' => '{{TOKEN_SUBSTITUIDO}}',
        '{{PROPOSTA_DATA_GERACAO}}' => '{{TOKEN_SUBSTITUIDO}}',
    ];
    $saidaDocx = storage_path('app/public/saida.docx');
    $saidaPdf = storage_path('app/public/saida.pdf');

    $service = new GeracaoModeloService();
    $service->substituirTokensNoDocxEConverterPdf($modeloDocx, $dados, $saidaDocx, $saidaPdf);

    // dd(EventoStatusEnum::options());

    // return Inertia::render('Teste', [
    //     // 'canLogin' => Route::has('login'),
    //     // 'canRegister' => Route::has('register'),
    //     'laravelVersion' => Application::VERSION,
    //     'phpVersion' => PHP_VERSION,
    //     'cidades' => Cidade::all()
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
    Route::resource('evento-servicos', EventoServicoController::class);
    Route::resource('vendedores', VendedorController::class)->parameters([
        'vendedores' => 'vendedor'
    ]);
    Route::resource('contratantes', ContratanteController::class);
    Route::resource('documentos-internos', DocumentoInternoController::class)->parameters([
        'documentos-internos' => 'documento'
    ]);
    Route::get('documentos-internos/download/{documento}', [DocumentoInternoController::class, 'download'])->name('documentos-internos.download');
    Route::resource('documentos-internos-categorias', DocumentoInternoCategoriaController::class);
});

Route::controller(EventoWorkflowController::class)->name('evento-workflow.')->group(function () {
    Route::middleware(['auth'])->group(function () {
        Route::get('evento-workflow/{evento}', 'show')->name('show');
        Route::post('evento-workflow/{evento}/enviar-formulario', 'enviarFormulario')->name('enviar-formulario-contratante');
        Route::post('evento-workflow/{evento}/gerar-proposta', 'gerarProposta')->name('gerar-proposta');
        Route::post('evento-workflow/{evento}/editar-proposta', 'editarProposta')->name('editar-proposta');
    });
    Route::get('contratante-formulario/{evento:token_formulario}', 'showFormulario')->name('contratante-formulario');
    Route::post('contratante-formulario/{evento:token_formulario}/salvar-formulario', 'salvarFormulario')->name('salvar-contratante-formulario');
});


require __DIR__ . '/auth.php';
