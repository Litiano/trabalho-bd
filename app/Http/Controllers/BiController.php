<?php

namespace App\Http\Controllers;

use App\Pedido;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BiController extends Controller
{


    public function index()
    {
        /**
         * Ticket médio
         * Faturamento por estabelecimento
         *
         */

        /*$sum = Pedido::query()->groupBy(["id_estabelecimento"])->selectSub("sum(valor_produtos)", "sumValor")
            ->selectSub("sum(1)", "qtd")->get(["id_estabelecimento"]);
        dd($sum);
        $qtd = Pedido::query()->groupBy(["id_estabelecimento"]);
        dd($qtd);*/

        $days = Pedido::getQuery()
            ->addSelect("avaliacao")
            ->selectSub("sum(1)", "qty")
            ->whereNotNull("avaliacao")
            ->groupBy("avaliacao")
            ->orderByDesc("avaliacao")
            ->get();
        dd($days);
    }

    public function daysOfWeek(Request $request)
    {
        $days = Pedido::getBillingByDayOfWeek();
        $data["labels"] = $days->pluck("label");
        $data["datasets"] = [
            ["label" => "Faturamento", "data" => $days->pluck("billing_total"),
                "fill" => true, "borderColor" => "rgb(75, 192, 192)", "lineTension" => 0.5]
        ];



        return view("bi.billing", compact("data", "days"));
    }
}
