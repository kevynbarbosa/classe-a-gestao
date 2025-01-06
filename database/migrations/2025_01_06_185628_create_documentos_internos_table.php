<?php

use App\Models\Artista;
use App\Models\DocumentoInternoCategoria;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('documentos_internos', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(DocumentoInternoCategoria::class)->constrained('documentos_internos_categorias');
            $table->foreignIdFor(Artista::class)->constrained();
            $table->string('nome_original');
            $table->string('path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos_internos');
    }
};
