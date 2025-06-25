<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstituicoesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('instituicoes')->insert([
            [
                "nome" => "Exercito Brasileiro",
                "sigla" => "EB",
                "img" => null
            ],
            [
                "nome" => "Força Aéria Brasileira",
                "sigla" => "FAB",
                "img" => null
            ],
            [
                "nome" => "Marinha do Brasil",
                "sigla" => "MB",
                "img" => null
            ]
        ]);
    }
}
