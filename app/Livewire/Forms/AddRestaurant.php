<?php

namespace App\Livewire\Forms;

use App\Enums\PackageType;
use App\Models\User;
use App\Models\Role;
use App\Models\Branch;
use App\Models\Country;
use App\Models\Package;
use Livewire\Component;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Http;
use App\Notifications\WelcomeRestaurantEmail;
use Spatie\Permission\Models\Permission;

class AddRestaurant extends Component
{

    public $restaurantName;
    public $sub_domain;
    public $fullName;
    public $email;
    public $password;
    public $branchName;
    public $address;
    public $country;
    public $countries;
    public $status;
    public $facebook;
    public $instagram;
    public $twitter;
    public $licenseType = 'free';
    public $showUserForm = true;
    public $showBranchForm = false;

    public function mount()
    {
        $this->countries = Country::all();

        $ip = request()->ip();
        $ipCountry = 'US';

        try {
            $response = Http::get('http://ip-api.com/json/' . $ip);

            if ($response->failed()) {
                $ipCountry = 'US';

            } else {
                if ($response->json()['status'] == 'success') {
                    $ipCountry = $response->json()['countryCode'];
                }
            }

        } catch (\Throwable $th) {
            $ipCountry = 'US';
        }


        $defaultCountry = Country::where('countries_code', $ipCountry)->first();
        $this->country = $defaultCountry->id;
    }

    public function submitForm()
    {
        $this->validate([
            'restaurantName' => 'required',
            'fullName' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'facebook' => 'required',
            'instagram' => 'required',
            'twitter' => 'required',

        ]);


        $this->showUserForm = false;
        $this->showBranchForm = true;
    }

    public function submitForm2()
    {
        $ip = request()->ip();

        try {
            $response = Http::get('http://ip-api.com/json/' . $ip);

            if ($response->failed()) {
                $timezone = 'UTC';

            } else {
                if ($response->json()['status'] == 'success') {
                    $timezone = $response->json()['timezone'] ?? 'UTC';
                }
            }

        } catch (\Throwable $th) {
             $timezone = 'UTC';
        }

        $this->validate([
            'address' => 'required',
            'branchName' => 'required'
        ]);


        $restaurant = new Restaurant();
        $restaurant->name = $this->restaurantName;
        $package = Package::firstWhere('package_type', PackageType::DEFAULT);

        if (module_enabled('Subdomain')) {
            $subdomain = strtolower(trim($this->sub_domain, '.') . '.' . getDomain());
            $restaurant->sub_domain = $subdomain;
        }

        $restaurant->hash = md5(microtime() . rand(1, 99999999));
        $restaurant->address = $this->address;
        $restaurant->timezone = $timezone ?? 'UTC';
        $restaurant->theme_hex = global_setting()->theme_hex;
        $restaurant->theme_rgb = global_setting()->theme_rgb;
        $restaurant->email = $this->email;
        $restaurant->country_id = $this->country;
        $restaurant->license_type = $this->licenseType;
        $restaurant->is_active = (bool) $this->status;
        $restaurant->facebook_link = $this->facebook;
        $restaurant->instagram_link = $this->instagram;
        $restaurant->twitter_link = $this->twitter;
        $restaurant->is_active = true;
        $restaurant->save();

        $branch = Branch::create([
            'name' => $this->branchName,
            'restaurant_id' => $restaurant->id,
            'address' => $this->address,
        ]);

        $user = User::create([
            'name' => $this->fullName,
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'facebook' => $this->facebook,
            'instagram' => $this->instagram,
            'twitter' => $this->twitter,
            'restaurant_id' => $restaurant->id,
            'branch_id' => $branch->id,
        ]);

        $adminRole = Role::create(['name' => 'Admin_'.$restaurant->id, 'display_name' => 'Admin', 'guard_name' => 'web', 'restaurant_id' => $restaurant->id   ]);
        $branchHeadRole = Role::create(['name' => 'Branch Head_'.$restaurant->id, 'display_name' => 'Branch Head', 'guard_name' => 'web', 'restaurant_id' => $restaurant->id]);
        $waiterRole = Role::create(['name' => 'Waiter_'.$restaurant->id, 'display_name' => 'Waiter', 'guard_name' => 'web', 'restaurant_id' => $restaurant->id]);
        $chefRole = Role::create(['name' => 'Chef_'.$restaurant->id, 'display_name' => 'Chef', 'guard_name' => 'web', 'restaurant_id' => $restaurant->id]);
        $allPermissions = Permission::get()->pluck('name')->toArray();

        $adminRole->syncPermissions($allPermissions);
        $branchHeadRole->syncPermissions($allPermissions);

        $user->assignRole('Admin_'.$restaurant->id);


        $user->notify(new WelcomeRestaurantEmail($restaurant));

        return $this->redirect(route('superadmin.restaurants.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.forms.add-restaurant');
    }

}
