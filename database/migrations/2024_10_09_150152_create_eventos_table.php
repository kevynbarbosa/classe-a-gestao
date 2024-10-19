<?php

use App\Models\Artista;
use App\Models\Cidade;
use App\Models\Contratante;
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
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Artista::class);
            $table->foreignIdFor(Contratante::class);
            $table->foreignIdFor(Cidade::class);
            $table->timestampTz('data_hora');
            $table->string('cidade_exterior')->nullable();
            $table->string('pais_exterior')->nullable();
            $table->string('recinto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};
