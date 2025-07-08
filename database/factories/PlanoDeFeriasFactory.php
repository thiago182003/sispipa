<?php

namespace Database\Factories;

use App\Models\Planodeferias;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PlanoDeFerias>
 */
class PlanoDeFeriasFactory extends Factory
{
    protected $model = Planodeferias::class;

    public function definition(): array
    {
        $qtdParcelas = $this->faker->randomElement([1, 2, 3]);

        return [
            'qtdparcelas' => $qtdParcelas,
            'p1inicio' => now()->addDays(10),
            'p1fim' => now()->addDays(20),
            'p2inicio' => $qtdParcelas > 1 ? now()->addDays(30) : null,
            'p2fim' => $qtdParcelas > 1 ? now()->addDays(40) : null,
            'p3inicio' => $qtdParcelas > 2 ? now()->addDays(50) : null,
            'p3fim' => $qtdParcelas > 2 ? now()->addDays(60) : null,
            'militar_id' => User::inRandomOrder()->first()->id, // Gera um usuário se necessário
            'anoreferencia' => now()->year,
            'status' => $this->faker->randomElement([0, 1]), // Exemplo: 0 = Pendente, 1 = Aprovado
        ];
    }
}
