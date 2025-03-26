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
        Schema::create('contratantes', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_pessoa');
            $table->string('cpf_cnpj')->nullable();
            $table->string('rg')->nullable();
            $table->string('nome_completo');
            $table->string('telefone')->nullable();
            $table->string('cep')->nullable();
            $table->string('endereco')->nullable();
            $table->string('numero')->nullable();
            $table->string('complemento')->nullable();
            $table->string('bairro')->nullable();
            $table->foreignIdFor(Cidade::class, 'cidade_id')->nullable()->constrained('cidades');

            $table->string('representante_legal_nome')->nullable();
            $table->string('representante_legal_cpf')->nullable();
            $table->string('representante_legal_rg')->nullable();
            $table->string('representante_legal_telefone')->nullable();
            $table->string('representante_legal_cep')->nullable();
            $table->string('representante_legal_endereco')->nullable();
            $table->string('representante_legal_numero')->nullable();
            $table->string('representante_legal_complemento')->nullable();
            $table->string('representante_legal_bairro')->nullable();
            $table->foreignIdFor(Cidade::class, 'representante_legal_cidade_id')->nullable()->constrained('cidades');

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
