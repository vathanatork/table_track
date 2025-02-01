<?php

namespace App\Console\Commands\SuperAdmin;

use App\Models\Restaurant;
use Illuminate\Console\Command;

class FreeLicenseRenew extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:free-license-renew';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Free license renew';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $restaurants = Restaurant::with('package')
        ->where('status', 'active')
        ->whereHas('package', function ($query) {
            $query->where('is_free', 1);
        })
        ->whereNotNull('license_expire_on')
        ->where('license_expire_on', '<', now())
        ->get();

        // Set default package for license expired restaurants.
        foreach ($restaurants as $restaurant) {
        $restaurant->license_expire_on = ($restaurant->package_type == 'monthly') ? now()->addMonth()->format('Y-m-d') : now()->addYear()->format('Y-m-d');
        $restaurant->save();
    }
    }
}
