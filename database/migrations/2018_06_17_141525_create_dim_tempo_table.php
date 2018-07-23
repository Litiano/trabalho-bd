<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDimTempoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dim_tempo', function (Blueprint $table) {
            $table->unsignedInteger('id')->primary();
            $table->unsignedInteger("dia");
            $table->unsignedInteger("mes");
            $table->string("mes_nome");
            $table->unsignedInteger("ano");
            //$table->unsignedInteger("bimestre");
            //$table->unsignedInteger("trimestre");
            //$table->unsignedInteger("quadrimestre");
            //$table->unsignedInteger("semana_ano");
            $table->unsignedInteger("dia_semana");
            $table->string("dia_semana_nome");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dim_tempo');
    }
}
