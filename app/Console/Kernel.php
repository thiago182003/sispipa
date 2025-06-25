<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Registra os comandos Artisan da aplicação.
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

    /**
     * Define as tarefas agendadas.
     */
    protected function schedule(Schedule $schedule)
    {
        // Rodar o comando de importação a cada minuto (para testar)
        $schedule->command('import:sheets')->everyMinute();
    }
}
