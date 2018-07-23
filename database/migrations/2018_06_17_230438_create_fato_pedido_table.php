<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFatoPedidoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fato_pedido', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('id_tempo');
            $table->foreign("id_tempo")->references('id')->on("dim_tempo");
            $table->unsignedInteger('id_turno_hora');
            $table->foreign("id_turno_hora")->references('id')->on("dim_turno_hora");
            $table->unsignedInteger('id_geografica')->nullable();
            $table->foreign("id_geografica")->references('id')->on("dim_geografica");

            $table->string('tipo_estabelecimento');
            $table->decimal('valor_produtos');
            $table->decimal('taxa_entrega');
            $table->decimal('total_pedido');
            $table->string('forma_pagamento');
            $table->decimal('avaliacao')->nullable();
            $table->string('status');

            $table->boolean('primeiro_pedido');
            $table->string('so_dispositivo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fato_pedido');
    }
}
