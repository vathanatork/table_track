<?php

namespace App\Livewire\Forms;

use App\Models\User;
use App\Models\Branch;
use App\Models\Role;
use App\Models\Country;
use Livewire\Component;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Providers\RouteServiceProvider;
use App\Notifications\NewRestaurantSignup;
use Illuminate\Support\Facades\Notification;
use App\Notifications\WelcomeRestaurantEmail;
use Spatie\Permission\Models\Permission;

class RestaurantSignup extends Component
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
    public $showUserForm = true;
    public $showBranchForm = false;

    public function mount()
    {
        if (user()) {
            return redirect('dashboard');
        }

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
            'password' => 'required'
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

        $requiresApproval = global_setting()->requires_approval_after_signup;
        $restaurant = new Restaurant();
        $restaurant->name = $this->restaurantName;

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
        $restaurant->approval_status = $requiresApproval ? 'Pending' : 'Approved';
        $restaurant->country_id = $this->country;
        $restaurant->about_us = Restaurant::ABOUT_US_DEFAULT_TEXT;
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

        Auth::loginUsingId($user->id);

        session(['user' => auth()->user()]);
        session(['restaurant' => $restaurant->fresh()]);
        session(['branch' => $branch]);

        $user->notify(new WelcomeRestaurantEmail($restaurant));

        $superadmins = User::withoutGlobalScopes()->role('Super Admin')->get();
        Notification::send($superadmins, new NewRestaurantSignup($restaurant));


        return redirect(RouteServiceProvider::ONBOARDING_STEPS);
    }

    public function render()
    {
        return view('livewire.forms.restaurant-signup');
    }

}
