<?php

namespace App;

use Carbon\Carbon;
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
 * @property int $id_tempo
 * @property int $id_dia
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pedido whereIdDia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pedido whereIdTempo($value)
 */
class Pedido extends Model
{
    protected $dates = ["data_pedido", "data_cadastro_usuario"];
    protected $table = "fato_pedido";

    public $timestamps = false;

    protected $guarded = [];

    /**
     * @param string $order
     * @param int $estabelecimentoId
     * @return Carbon|mixed
     */
    protected static function getDate(string $order = "asc", int $estabelecimentoId = null)
    {
        /** @var Pedido $pedido */
        $query = Pedido::query()->orderBy("data_pedido", $order);
        if ($estabelecimentoId) {
            $query->where("id_estabelecimento", $estabelecimentoId);
        }
        $pedido = $query->first();
        if (!$pedido) {
            return Carbon::now();
        }
        return $pedido->data_pedido;
    }

    /**
     * @param int $estabelecimentoId
     * @return Carbon|mixed
     */
    public static function getFirstDate(int $estabelecimentoId = null)
    {
        return self::getDate("asc", $estabelecimentoId);
    }

    /**
     * @param int $estabelecimentoId
     * @return Carbon|mixed
     */
    public static function getLastDate(int $estabelecimentoId = null)
    {
        return self::getDate("desc", $estabelecimentoId);
    }

    /**
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    public static function getBestClients(int $limit = 10)
    {
        return Pedido::getQuery()
            ->select(["id_usuario"])
            ->selectSub("sum(1)", "qty")
            ->where("status", "=", "Entregue")
            ->groupBy("id_usuario")
            ->orderByDesc("qty")
            ->limit(min(100, $limit))
            ->get();
    }

    public static function getBillingByDayOfWeek()
    {
        // Add 0 day and 3 hours
        $dayOfWeek = "DAYOFWEEK(ADDTIME(data_pedido, '0 3'))";
        $days = Pedido::getQuery()
            ->selectSub($dayOfWeek, "dayOfWeek")
            ->selectSub("sum(total_pedido)", "billing_total")
            ->groupBy(\DB::raw($dayOfWeek))
            ->orderBy(\DB::raw($dayOfWeek))
            ->get();

        foreach ($days as &$day) {
            $day->label = trans("daysOfWeek.mysql.{$day->dayOfWeek}");
        }
        return $days;
    }

    public static function getRatings()
    {
        return Pedido::getQuery()
            ->addSelect("avaliacao")
            ->selectSub("sum(1)", "qty")
            ->whereNotNull("avaliacao")
            ->groupBy("avaliacao")
            ->orderByDesc("avaliacao")
            ->get();
    }

}
