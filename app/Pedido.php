<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Pedido
 *
 * @property int $id
 * @property \Carbon\Carbon $data_pedido
 * @property float $valor_produtos
 * @property float $taxa_entrega
 * @property float $total_pedido
 * @property string $forma_pagamento
 * @property float|null $avaliacao
 * @property string $status
 * @property int $id_estabelecimento
 * @property string $tipo_estabelecimento
 * @property int $id_usuario
 * @property string $ddd_usuario
 * @property \Carbon\Carbon $data_cadastro_usuario
 * @property bool $primeiro_pedido
 * @property string|null $bairro_usuario
 * @property string|null $cidade_usuario
 * @property string $so_dispositivo
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pedido whereAvaliacao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pedido whereBairroUsuario($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pedido whereCidadeUsuario($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pedido whereDataCadastroUsuario($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pedido whereDataPedido($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pedido whereDddUsuario($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pedido whereFormaPagamento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pedido whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pedido whereIdEstabelecimento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pedido whereIdUsuario($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pedido wherePrimeiroPedido($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pedido whereSoDispositivo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pedido whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pedido whereTaxaEntrega($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pedido whereTipoEstabelecimento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pedido whereTotalPedido($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pedido whereValorProdutos($value)
 * @mixin \Eloquent
 */
class Pedido extends Model
{
    protected $dates = ["data_pedido", "data_cadastro_usuario"];
    protected $table = "pedidos";

    public $timestamps = false;

    protected $guarded = [];


}
