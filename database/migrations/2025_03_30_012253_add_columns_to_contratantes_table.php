<?php

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
        Schema::table('contratantes', function (Blueprint $table) {
            $table->string('email')->nullable()->after('telefone');
            $table->after('representante_legal_cidade_id', function ($table) {
                $table->string('representante_legal_sexo')->nullable();
                $table->string('representante_legal_nacionalidade')->nullable();
                $table->string('representante_legal_estado_civil')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contratantes', function (Blueprint $table) {
            $table->dropColumn([
                'email',
                'representante_legal_sexo',
                'representante_legal_nacionalidade',
                'representante_legal_estado_civil',
            ]);
        });
    }
};
