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
        Schema::create('cidades', function (Blueprint $table) {
            $table->id();
            $table->string('municipio')->nullable();
            $table->string('uf')->nullable();
            $table->string('uf_code')->nullable();
            $table->string('name')->nullable();
            $table->string('mesoregion')->nullable();
            $table->string('microregion')->nullable();
            $table->string('rgint')->nullable();
            $table->string('rgi')->nullable();
            $table->string('osm_relation_id')->nullable();
            $table->string('wikidata_id')->nullable();
            $table->string('is_capital')->nullable();
            $table->string('wikipedia_pt')->nullable();
            $table->string('lon')->nullable();
            $table->string('lat')->nullable();
            $table->string('no_accents')->nullable();
            $table->string('slug_name')->nullable();
            $table->string('alternative_names')->nullable();
            $table->string('pop_21')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cidades');
    }
};
