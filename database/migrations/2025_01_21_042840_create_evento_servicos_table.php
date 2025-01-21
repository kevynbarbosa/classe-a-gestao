<?php

use App\Models\Evento;
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
        Schema::create('evento_servicos', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Evento::class)->constrained();
            $table->string('descricao');
            $table->decimal('valor', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evento_servicos');
    }
};
