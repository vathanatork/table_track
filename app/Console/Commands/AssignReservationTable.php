<?php

namespace App\Console\Commands;

use App\Models\Reservation;
use App\Models\Restaurant;
use App\Models\Table;
use Illuminate\Console\Command;

class AssignReservationTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:assign-reservation-table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for next 1 hour reservation tables and change the status of the table accordingly';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Fetch reservations which are in next 1 hour
        $setting = Restaurant::first();
        $start = now($setting->timezone)->toDateTimeString();
        $end = now($setting->timezone)->addHour()->toDateTimeString();
        
        $reservations = Reservation::where('reservation_date_time', '>=', $start)
            ->where('reservation_date_time', '<=', $end)
            ->whereNotNull('table_id')
            ->get();

        foreach ($reservations as $reservation) {
            Table::where('id', $reservation->table_id)->update(['available_status' => 'reserved']);
        }
    }

}
