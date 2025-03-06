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
        Schema::create('contratantes', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_pessoa');
            $table->string('cpf_cnpj');
            $table->string('rg')->nullable();
            $table->string('nome_completo');
            $table->string('telefone')->nullable();
            $table->string('foto_path')->nullable();
            $table->string('cep')->nullable();
            $table->string('endereco')->nullable();
            $table->string('numero')->nullable();
            $table->string('complemento')->nullable();
            $table->string('bairro')->nullable();
            $table->string('cidade')->nullable();
            $table->string('nome_representante_legal')->nullable();
            $table->string('cpf_representante_legal')->nullable();
            $table->string('rg_representante_legal')->nullable();
            $table->string('cep_representante_legal')->nullable();
            $table->string('endereco_representante_legal')->nullable();
            $table->string('numero_representante_legal')->nullable();
            $table->string('complemento_representante_legal')->nullable();
            $table->string('bairro_representante_legal')->nullable();
            $table->string('cidade_representante_legal')->nullable();
            $table->string('telefone_representante_legal')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contratantes');
    }
};
