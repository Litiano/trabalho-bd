<?php

namespace App\Dim\Data;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Dim\Data\Dia
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $hora
 * @property string $turno
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dim\Data\Dia whereHora($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dim\Data\Dia whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dim\Data\Dia whereTurno($value)
 */
class Dia extends Model
{
    protected $table = "dim_tempo_dia";
    public $incrementing = false;
    public $timestamps = false;

    public static function getDia(Carbon $data)
    {
        $dia = Dia::find($data->hour);
        if(!$dia) {
            $dia = new Dia();
            $dia->id = $data->hour;
            $dia->hora = $data->hour;
            $dia->turno = self::getTurno($data->hour);
            $dia->save();
        }
        return $dia;
    }

    protected static function getTurno($hora)
    {
        if($hora > 0 && $hora <= 12) {
            return "Manhã";
        }

        if($hora > 12 && $hora <= 18) {
            return "Tarde";
        }

        return "Noite";

    }
}
