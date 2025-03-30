<?php

use App\Models\Cidade;
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
        Schema::table('artistas', function (Blueprint $table) {
            $table->after('representante_legal_email', function ($table) {
                $table->string('representante_legal_endereco')->nullable();
                $table->string('representante_legal_numero')->nullable();
                $table->string('representante_legal_complemento')->nullable();
                $table->string('representante_legal_cep')->nullable();
                $table->foreignIdFor(Cidade::class, 'representante_legal_cidade_id')->nullable()->constrained('cidades');
                $table->string('representante_legal_telefone')->nullable();
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
        Schema::table('artistas', function (Blueprint $table) {
            $table->dropForeign(['representante_legal_cidade_id']);
            $table->dropColumn([
                'representante_legal_endereco',
                'representante_legal_numero',
                'representante_legal_complemento',
                'representante_legal_cep',
                'representante_legal_cidade_id',
                'representante_legal_telefone',
                'representante_legal_nacionalidade',
                'representante_legal_estado_civil',
                'representante_legal_sexo'
            ]);
        });
    }
};
