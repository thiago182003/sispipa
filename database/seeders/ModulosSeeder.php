<?php

namespace Database\Seeders;

use App\Models\Modulos;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModulosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('modulos')->insert([
            [
                "nome" => "administrativo",
                "descricao" => ""
            ],
            [
                "nome" => "erocp",
                "descricao" => ""
            ],
            [
                "nome" => "e1",
                "descricao" => ""
            ]
        ]);
    }
}
