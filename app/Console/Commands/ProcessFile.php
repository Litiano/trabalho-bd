<?php

namespace App\Console\Commands;

use App\Dimensao\Geografica;
use App\Dimensao\Tempo;
use App\Dimensao\Turno;
use App\Pedido;
use App\Usuario;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Jenssegers\Date\Date;

class ProcessFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:file';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Processa o arquivo CSV';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->setProcessTitle("Processando arquivo CSV");
        $this->info("Processando arquivo CSV...");

        $file = file_get_contents(base_path('aplicativo.csv'));
        $lines = explode("\n", $file);
        $bar = $this->output->createProgressBar(count($lines));
        $bar->start();
        $ignored = 0;

        try {
            DB::transaction(function () use (&$ignored, $bar, $lines) {
                foreach ($lines as $key => $line) {
                    if ($key === 0 || $line === "") {
                        $bar->advance();
                        continue;// skip first line, header
                    }
                    $data = $this->processLine($line);

                    $total = $data["valor_produtos"] + $data["taxa_entrega"];
                    if (bccomp($total, $data["total_pedido"], 2) !== 0 && $data["status"] === "Entregue") {
                        $this->line("");
                        $this->alert("Igonarando linha com valor total inconsistente!");
                        $bar->advance();
                        $ignored++;
                        continue;
                    }

                    $data["id_tempo"] = Tempo::getTempo($data["data_pedido"])->id;
                    $data["id_turno_hora"] = Turno::getDia($data["data_pedido"])->id;
                    if(!$data["cidade"] || !$data["bairro"]) {
                        $this->line("");
                        $this->alert("Igonarando linha com cidade/bairro nulo!");
                        $bar->advance();
                        $ignored++;
                        continue;
                    }
                    $data["id_geografica"] = Geografica::firstOrCreate(
                        ["cidade" => $data['cidade'], "bairro" => $data['bairro']
                        ])->id;
                    unset($data["data_pedido"]);
                    unset($data["cidade"]);
                    unset($data["bairro"]);
                    //dd($data);

                    Pedido::create($data);
                    $bar->advance();
                }
            });
            $bar->finish();
            $this->line("");
            $this->warn("{$ignored} ignorados!");
            $this->info("Arquivo processado com sucesso!");
        } catch (\Exception $e) {
            $this->line("");
            $this->error("Erro ao processar arquivo, nada foi alterado, foi feito um rollback!");
            $this->error("Error: {$e->getMessage()}");
            return false;
        }
        return true;
    }

    protected function processLine($line)
    {
        $line = trim($line);
        $columns = explode(",", $line);

        /** Limpa cada item das colunas, tira as aspas e espaços em branco e verifica se é null*/
        array_walk($columns, function (&$item) {
            if ($item === 'NULL') {
                $item = null;
                return;
            }
            $item = trim($item, "\"");
            $item = trim($item);
        });

        $data["data_pedido"] = Carbon::createFromFormat("Y-m-d H:i", "{$columns[0]} {$columns[1]}");
        $data["valor_produtos"] = $columns[3];
        $data["taxa_entrega"] = $columns[4];
        $data["total_pedido"] = $columns[5];
        $data["forma_pagamento"] = $columns[6];
        $data["avaliacao"] = $columns[7];
        $data["status"] = $columns[8];

        $data["tipo_estabelecimento"] = $columns[10];


        $data["primeiro_pedido"] = mb_strtolower($columns[14]) === "sim" ? true : false;
        $data["bairro"] = $columns[15];
        $data["cidade"] = $columns[16];
        $data["so_dispositivo"] = $columns[17];

        /**
         * @TODO validate
         */

        return $data;
    }
}
