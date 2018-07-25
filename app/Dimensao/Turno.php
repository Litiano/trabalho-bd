<?php

namespace App\Dimensao;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Turno extends Model
{
    protected $table = "dim_turno_hora";
    public $incrementing = false;
    public $timestamps = false;

    public static function getDia(Carbon $data)
    {
        $dia = Turno::find($data->hour);
        if(!$dia) {
            $dia = new Turno();
            $dia->id = $data->hour;
            $dia->hora = $data->hour;
            $dia->turno = self::getTurno($data->hour);
            $dia->save();
        }
        return $dia;
    }

    protected static function getTurno($hora)
    {
        if($hora >= 5 && $hora <= 12) {
            return "1-Manhã";
        }

        if($hora > 12 && $hora <= 18) {
            return "2-Tarde";
        }

        return "3-Noite";

    }
}
