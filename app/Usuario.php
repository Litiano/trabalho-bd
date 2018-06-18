<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Usuario
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $ddd
 * @property string $data_cadastro
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Usuario whereDataCadastro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Usuario whereDdd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Usuario whereId($value)
 */
class Usuario extends Model
{
    protected $table = "dim_usuario";
    protected $guarded = [];
    public $timestamps = false;
}
