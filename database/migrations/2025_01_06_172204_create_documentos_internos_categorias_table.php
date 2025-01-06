<?php

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
        Schema::create('documentos_internos_categorias', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(DocumentoInternoCategoria::class, 'categoria_pai_id')->constrained('documentos_internos_categorias', 'id', 'categoria_pai_index');
            $table->string('nome');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos_internos_categorias');
    }
};
