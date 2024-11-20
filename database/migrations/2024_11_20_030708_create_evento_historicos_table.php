<?php

use App\Models\Evento;
use App\Models\User;
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
        Schema::create('evento_historicos', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Evento::class)->constrained();
            $table->foreignIdFor(User::class)->nullable()->constrained();
            $table->string('status_anterior')->nullable();
            $table->string('status_atual');
            $table->string('observacao')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evento_historicos');
    }
};
