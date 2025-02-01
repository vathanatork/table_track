<?php

namespace App\Providers;

use App\Http\Middleware\SuperAdmin;
use App\Models\Area;
use App\Models\Branch;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\DeliveryExecutive;
use App\Models\FileStorage;
use App\Models\ItemCategory;
use App\Models\Kot;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\NotificationSetting;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\PaymentGatewayCredential;
use App\Models\Reservation;
use App\Models\ReservationSetting;
use App\Models\Restaurant;
use App\Models\Table;
use App\Models\Tax;
use App\Models\User;
use App\Observers\AreaObserver;
use App\Observers\BranchObserver;
use App\Observers\CurrencyObserver;
use App\Observers\CustomerObserver;
use App\Observers\DeliveryExecutiveObserver;
use App\Observers\FileStorageObserver;
use App\Observers\ItemCategoryObserver;
use App\Observers\KotObserver;
use App\Observers\MenuItemObserver;
use App\Observers\MenuObserver;
use App\Observers\NotificationSettingObserver;
use App\Observers\OrderItemObserver;
use App\Observers\OrderObserver;
use App\Observers\PaymentGatewayObserver;
use App\Observers\PaymentObserver;
use App\Observers\ReservationObserver;
use App\Observers\ReservationSettingObserver;
use App\Observers\RestaurantObserver;
use App\Observers\RoleObserver;
use App\Observers\TableObserver;
use App\Observers\TaxObserver;
use App\Observers\UserObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     */
    public function register(): void
    {
        if (config('app.redirect_https')) {
            $this->app['request']->server->set('HTTPS', true);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.redirect_https')) {
            URL::forceScheme('https');
        }

        Schema::defaultStringLength(191);
        // Link observers with models
        Area::observe(AreaObserver::class);
        User::observe(UserObserver::class);
        ItemCategory::observe(ItemCategoryObserver::class);
        Kot::observe(KotObserver::class);
        MenuItem::observe(MenuItemObserver::class);
        Menu::observe(MenuObserver::class);
        OrderItem::observe(OrderItemObserver::class);
        Order::observe(OrderObserver::class);
        Payment::observe(PaymentObserver::class);
        ReservationSetting::observe(ReservationSettingObserver::class);
        Reservation::observe(ReservationObserver::class);
        Table::observe(TableObserver::class);
        PaymentGatewayCredential::observe(PaymentGatewayObserver::class);
        Tax::observe(TaxObserver::class);
        Currency::observe(CurrencyObserver::class);
        NotificationSetting::observe(NotificationSettingObserver::class);
        Customer::observe(CustomerObserver::class);
        Restaurant::observe(RestaurantObserver::class);
        Branch::observe(BranchObserver::class);
        FileStorage::observe(FileStorageObserver::class);
        DeliveryExecutive::observe(DeliveryExecutiveObserver::class);



        // Implicitly grant "Admin" role all permissions
        // This works in the app by using gate-related functions like auth()->user->can() and @can()
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Admin_'.$user->restaurant_id) ? true : null;
        });

        // Search macro for searching in tables.
        Builder::macro('search', function ($field, $string) {
            return $string ? $this->where($field, 'like', '%'.$string.'%') : $this;
        });

        // Model::preventLazyLoading(app()->environment('development'));
    }

}
