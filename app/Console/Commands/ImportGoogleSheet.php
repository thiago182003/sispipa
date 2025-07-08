<?php

/* namespace App\Console\Commands;

use App\Models\Ouvidoria;
use Illuminate\Console\Command;
use App\Services\GoogleService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ImportGoogleSheet extends Command
{
    protected $signature = 'import:sheet';
    protected $description = 'Importa dados do Google Sheets para o MySQL';

    protected $googleSheetsService;

    public function __construct(GoogleService $googleSheetsService)
    {
        parent::__construct();
        $this->googleSheetsService = $googleSheetsService;
    }

    public function handle()
    {
        $range = 'A2:N'; // Ajuste conforme necessário (exemplo: Colunas A a D)
        $data = $this->googleSheetsService->getData($range);
        if (!empty($data)) {
            DB::statement('truncate Table ouvidoria');
            foreach ($data as $row) {
                $hora = isset($row[0]) ? Carbon::createFromFormat('d/m/Y H:i:s', $row[0])->format('Y-m-d H:i:s') : null;
                if(!$hora){
                    continue;
                }
                // dd($row);
                // Ajuste conforme a estrutura do seu modelo
                Ouvidoria::create(
                    // ['id' => $row[0]], // Supondo que a primeira coluna seja o ID
                    [
                        "hora" => isset($row[0]) ? Carbon::createFromFormat('d/m/Y H:i:s', $row[0])->format('Y-m-d H:i:s') : null,
                        "nome" => $row[1] ?? null,
                        "municipio" => $row[2] ?? null,
                        "requerente" => $row[3] ?? null,
                        "email" => $row[8] ?? null,
                        "cpf" => $row[5] ?? null,
                        "telefone" => $row[6] ?? null,
                        "relato" => $row[7] ?? null,
                        "protocolo" => $row[10] ?? null,
                        "resolucao" => $row[11] ?? null,
                        "status" => $row[12] ?? null,
                        "dias" => $row[13] ?? null,
                    ]
                );
            }
            $this->info('Dados importados com sucesso!');
        } else {
            $this->warn('Nenhum dado encontrado.');
        }
    }
} */
