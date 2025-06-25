<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::updateOrCreate(
            [
                'cpf' => '00000000000',
                'nome' => 'Administrador',
                'nomeguerra' => 'Admin',
                'identidade' => null,
                'identidade_emissor' => null,
                'identidade_data' => null,
                'identidade_militar' => null,
                'telefone' => null,
                'email' => null,
                'veterano' => false,
                'dtnascimento' => null,
                'dtpraca' => null,
                'om_servico_id' => null,
                'om_vinculo_id' => null,
                'secao_id' => null,
                'postograduacao_id' => null,
                'email_verified_at' => null,
                'password' => Hash::make(''),
                'status' => 1,
                'level' => 0,
                'img' => null,
            ]
        );
    }
}
