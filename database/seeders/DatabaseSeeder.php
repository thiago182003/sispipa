<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AdminSeeder::class);
        $this->call(InstituicoesSeeder::class);
        $this->call(PostoGraduacoesSeeder::class);
        $this->call(ModulosSeeder::class);
        $this->call(SituacoesSeeder::class);
        $this->call(OMsSeeder::class);
    }
}
