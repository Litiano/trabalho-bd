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
            $table->dateTime("data_pedido"); //Data+Hora
            $table->unsignedInteger('id_tempo');
            $table->foreign("id_tempo")->references('id')->on("dim_tempo");
            $table->unsignedInteger('id_dia');
            $table->foreign("id_dia")->references('id')->on("dim_tempo_dia");
            $table->decimal('valor_produtos');
            $table->decimal('taxa_entrega');
            $table->decimal('total_pedido');
            $table->string('forma_pagamento');
            $table->decimal('avaliacao')->nullable();
            $table->string('status');
            $table->unsignedInteger('id_estabelecimento');
            $table->foreign("id_estabelecimento")->references("id")->on("dim_estabelecimento");
            //$table->string('tipo_estabelecimento');
            $table->unsignedInteger('id_usuario');
            $table->foreign("id_usuario")->references("id")->on("dim_usuario");
            //$table->string('ddd_usuario');
            //$table->date('data_cadastro_usuario');
            $table->boolean('primeiro_pedido');
            $table->string('bairro_usuario')->nullable();
            $table->string('cidade_usuario')->nullable();
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
