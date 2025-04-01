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
        Schema::create('evento_pagamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Evento::class)->constrained();
            $table->date('data_pagamento');
            $table->decimal('valor', 12, 2);
            $table->string('tipo')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evento_pagamentos');
    }
};
