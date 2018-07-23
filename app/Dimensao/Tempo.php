<?php

namespace App\Dimensao;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Tempo extends Model
{
    protected $table = "dim_tempo";
    public $incrementing = false;
    public $timestamps = false;

    public static function getTempo(Carbon $data)
    {
        $tempo = Tempo::find($data->format("Ymd"));

        if(!$tempo) {
            $tempo = new Tempo();
            $tempo->id = $data->format("Ymd");
            $tempo->ano = $data->year;
            $tempo->mes = $data->month;
            $tempo->mes_nome = $data->format('F');
            $tempo->dia_semana = $data->dayOfWeek;
            $tempo->dia_semana_nome = $data->format('l');
            $tempo->dia = $data->day;
            $tempo->save();
        }
        return $tempo;
    }
}
