<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\Inspire::class,
        \App\Console\Commands\GajiBulanan::class,
        \App\Console\Commands\GajiMingguan::class,
        \App\Console\Commands\ImportDataCustomer::class,
        \App\Console\Commands\ImportDataSupplier::class,
        \App\Console\Commands\ImportDataGiro::class,
        \App\Console\Commands\ImportDataKaryawan::class,
        \App\Console\Commands\ImportDataKas::class,
        \App\Console\Commands\ImportDataStok::class,
        \App\Console\Commands\ImportDataStokMinyak::class,
        \App\Console\Commands\ImportHutang::class,
        \App\Console\Commands\ImportPiutang::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('inspire')
                 ->hourly();
        $schedule->command('gaji:bulanan')
                 ->cron('0 0 1 * *');
        $schedule->command('gaji:mingguan')
                 ->cron('0 0 * * 0');
    }
}
