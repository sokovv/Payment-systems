<?php

namespace App\Console;

use App\Models\Transfer;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Auth\User;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

/**
 * Summary of Kernel
 */
class Kernel extends ConsoleKernel
{

    public $date_transfer;
    public $minute;
    public $hour;
    public $dayMonth;
    public $month;
    public $day;

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {

        $schedule->call(function () {

            $this->date_transfer = Transfer::get();

            for ($i = 0; $i < $this->date_transfer->count(); $i++) {
                // $minute = $this->minute = $this->date_transfer[$i]->date_transfer->format('i'); с точностю до минуты
                $hour = $this->hour = $this->date_transfer[$i]->date_transfer->format('G');
                $dayMonth = $this->dayMonth = $this->date_transfer[$i]->date_transfer->format('j');
                $month = $this->month = $this->date_transfer[$i]->date_transfer->format('M');
                $day = $this->day = $this->date_transfer[$i]->date_transfer->format('D');
                if (date('G') === $hour && date('j') === $dayMonth && date('M') === $month && date('D') === $day) {
                    $user_recipient = User::class::find($this->date_transfer[$i]->id_recipient);
                    $user_recipient->balance += $this->date_transfer[$i]->summa;
                    $user_recipient->save();

                }
            }

        })->cron("0 * * * *");

    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
