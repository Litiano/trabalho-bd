<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Estabelecimento
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $tipo
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Estabelecimento whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Estabelecimento whereTipo($value)
 */
class Estabelecimento extends Model
{
    protected $table = "dim_estabelecimento";
    protected $guarded = [];
    public $timestamps = false;
}
