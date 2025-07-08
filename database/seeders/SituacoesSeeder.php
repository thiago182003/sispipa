<?php

namespace Database\Seeders;

use App\Models\Situacoes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SituacoesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('situacoes')->insert([
            [
                "nome" => "Seção",
                "descricao" => ""
            ],
            [
                "nome" => "Férias",
                "descricao" => ""
            ],
            [
                "nome" => "Dispensa secão",
                "descricao" => ""
            ],
            [
                "nome" => "Dispensa medica",
                "descricao" => ""
            ],
            [
                "nome" => "Missão",
                "descricao" => ""
            ],
            [
                "nome" => "Missão Externa",
                "descricao" => ""
            ],
            [
                "nome" => "Home Office",
                "descricao" => ""
            ],
            [
                "nome" => "Desconto em férias",
                "descricao" => ""
            ]
        ]);
    }
}
