<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OMsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('oms')->insert([
            [
                "id" => 1,
                "nome" => "Comando Militar do Nordeste",
                "sigla" => "CMNE",
                "img" => null,
                "superior_id" => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                "id" => 2,
                "nome" => "Comando da 7ª Região Militar",
                "sigla" => "7ª RM",
                "img" => null,
                "superior_id" => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                "id" => 3,
                "nome" => "Base Administrativa do Curado",
                "sigla" => "Ba Adm Curado",
                "img" => null,
                "superior_id" => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                "id" => 4,
                "nome" => "4º Batalhão de Policia do Exercito",
                "sigla" => "4º BPE",
                "img" => null,
                "superior_id" => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                "id" => 5,
                "nome" => "7º Grupamento de Artilharia de Campanha",
                "sigla" => "7º GAC",
                "img" => null,
                "superior_id" => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ]);
    }
}
