<?php

namespace App\Dim;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Dim\Tempo
 *
 * @property int $id
 * @property int $dia
 * @property int $mes
 * @property int $ano
 * @property int $trimestre
 * @property int $semana_ano
 * @property int $dia_semana
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dim\Tempo whereAno($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dim\Tempo whereDia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dim\Tempo whereDiaSemana($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dim\Tempo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dim\Tempo whereMes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dim\Tempo whereSemanaAno($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dim\Tempo whereTrimestre($value)
 * @mixin \Eloquent
 * @property string $mes_nome
 * @property string $dia_semana_nome
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dim\Tempo whereDiaSemanaNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dim\Tempo whereMesNome($value)
 */
class Tempo extends Model
{
    protected $table = "dim_tempo";
    public $incrementing = false;
    public $timestamps = false;

    public static function firstOrNew($attributes, $values = array())
    {

        return parent::firstOrNew($attributes, $values);
    }

    public static function getTempo(Carbon $data)
    {
        $tempo = Tempo::find($data->format("Ymd"));

        if(!$tempo) {
            $tempo = new Tempo();
            $tempo->id = $data->format("Ymd");
            $tempo->ano = $data->year;
            $tempo->mes = $data->month;
            $tempo->mes_nome = $data->format('F');
            $tempo->dia = $data->day;
            $tempo->dia_semana = $data->dayOfWeek;
            $tempo->trimestre = $data->quarter;
            $tempo->semana_ano = $data->weekOfYear;
            $tempo->dia_semana_nome = $data->format('l');
            $tempo->save();
        }
        return $tempo;
    }
}
