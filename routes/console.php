<?php

use App\Console\Commands\AssignReservationTable;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

// Schedule::command('demo:seed')->everyTwoHours();
Schedule::command('app:assign-reservation-table')->hourly();

Schedule::command('app:trial-expire')->daily();
Schedule::command('app:license-expire')->daily();
Schedule::command('app:subscription-expire-reminder')->daily();
Schedule::command('app:hide-cron-job-message')->everyMinute();
