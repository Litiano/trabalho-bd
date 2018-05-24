<?php

namespace App\Console\Commands;

use App\Pedido;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ProcessFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'precess:file';

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
        $this->setProcessTitle("Processamento do arquivo CSV");
        $this->info("Processamento do arquivo CSV...");

        $file = file_get_contents(base_path('aplicativo.csv'));
        $lines = explode("\n", $file);
        $bar = $this->output->createProgressBar(count($lines));
        $bar->start();

        try {
            DB::transaction(function () use ($bar, $lines) {
                foreach ($lines as $key => $line) {
                    if($key === 0 || $line === "") {
                        $bar->advance();
                        continue;// skip first line, header
                    }
                    $data = $this->processLine($line);
                    Pedido::create($data);
                    $bar->advance();
                }
            });
            $bar->finish();
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
        array_walk($columns, function (&$item){
            if($item === 'NULL') {
                $item = null;
                return;
            }
            $item = trim($item, "\"");
            $item = trim($item);
        });

        $data["data_pedido"] = Carbon::createFromFormat("Y-m-d H:i", "{$columns[0]} {$columns[1]}");
        //$data["DIA_PEDIDO"] = $columns[2]; //não precisa
        $data["valor_produtos"] = $columns[3];
        $data["taxa_entrega"] = $columns[4];
        $data["total_pedido"] = $columns[5];
        $data["forma_pagamento"] = $columns[6];
        $data["avaliacao"] = $columns[7];
        $data["status"] = $columns[8];
        $data["id_estabelecimento"] = $columns[9];
        $data["tipo_estabelecimento"] = $columns[10];
        $data["id_usuario"] = $columns[11];
        $data["ddd_usuario"] = $columns[12];
        $data["data_cadastro_usuario"] = Carbon::createFromFormat("Y-m-d", $columns[13]);
        $data["primeiro_pedido"] = mb_strtolower($columns[14]) === "sim" ? true : false;
        $data["bairro_usuario"] = $columns[15];
        $data["cidade_usuario"] = $columns[16];
        $data["so_dispositivo"] = $columns[17];

        /**
         * @TODO validate
         */

        return $data;
    }
}
