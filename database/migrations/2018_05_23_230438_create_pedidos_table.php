<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime("data_pedido"); //Data+Hora
            $table->decimal('valor_produtos');
            $table->decimal('taxa_entrega');
            $table->decimal('total_pedido');
            $table->string('forma_pagamento');
            $table->decimal('avaliacao')->nullable();
            $table->string('status');
            $table->unsignedInteger('id_estabelecimento');
            $table->string('tipo_estabelecimento');
            $table->unsignedInteger('id_usuario');
            $table->string('ddd_usuario');
            $table->date('data_cadastro_usuario');
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
        Schema::dropIfExists('pedidos');
    }
}
