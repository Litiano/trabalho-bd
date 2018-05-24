<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Pedido
 *
 * @mixin \Eloquent
 */
class Pedido extends Model
{
    protected $table = "pedidos";

    public $timestamps = false;

    protected $guarded = [];


}
