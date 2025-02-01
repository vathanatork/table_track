<?php

use App\Enums\PackageType;
use App\Exports\PaymentExport;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeliveryExecutiveController;
use App\Http\Controllers\GlobalSettingController;
use App\Http\Controllers\ItemCategoryController;
use App\Http\Controllers\KotController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\OnboardingStepController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\RestaurantPaymentController;
use App\Http\Controllers\RestaurantSettingController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\SuperadminSettingController;
use App\Http\Controllers\TableController;
use App\Http\Middleware\LocaleMiddleware;
use App\Http\Middleware\SuperAdmin;
use App\Models\Package;
use App\Models\Module;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\LandingSiteController;
use App\Http\Middleware\DisableFrontend;
use App\Http\Controllers\WaiterRequestController;

Route::middleware([LocaleMiddleware::class])->group(function () {

    Route::get('/', function () {
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            echo view('vendor.froiden-envato.install_message');
            exit(1);
        }

        if (global_setting()->landing_site_type == 'custom') {
            return response(file_get_contents(global_setting()->landing_site_url));
        }

        // return view('shop.index');

        $modules = Module::all();

        $packages = Package::with('modules')
        ->where('package_type', '!=', PackageType::DEFAULT)
        ->where('package_type', '!=', PackageType::TRIAL)
        ->where('is_private', false)
        ->get();

        $trialPackage = Package::where('package_type', PackageType::TRIAL)->first();

        return view('landing.index', compact('packages', 'modules', 'trialPackage'));
    })->name('home')->middleware(DisableFrontend::class);

    Route::group(['prefix' => 'restaurant'], function () {
        Route::get('/table/{hash}', [ShopController::class, 'tableOrder'])->name('table_order');
        Route::get('/my-orders/{hash}', [ShopController::class, 'myOrders'])->name('my_orders');
        Route::get('/my-bookings/{hash}', [ShopController::class, 'myBookings'])->name('my_bookings');
        Route::get('/book-a-table/{hash}', [ShopController::class, 'bookTable'])->name('book_a_table');
        Route::get('/contact/{hash}', [ShopController::class, 'contact'])->name('contact');
        Route::get('/about-us/{hash}', [ShopController::class, 'about'])->name('about');
        Route::get('/profile/{hash}', [ShopController::class, 'profile'])->name('profile');
        Route::get('/orders-success/{id}', [ShopController::class, 'orderSuccess'])->name('order_success');
    });

    Route::get('/restaurant-signup', function () {
        if (global_setting()->disable_landing_site) {
            return view('auth.restaurant_register');
        }

        return view('auth.restaurant_signup');
    })->name('restaurant_signup');
    Route::get('/restaurant/{hash}', [ShopController::class, 'cart'])->name('shop_restaurant');

    Route::get('/customer-logout', function () {
        session()->flush();
        return redirect('/');
    })->name('customer_logout');


    Route::post('stripe/order-payment', [StripeController::class, 'orderPayment'])->name('stripe.order_payment');
    Route::get('/stripe/success-callback', [StripeController::class, 'success'])->name('stripe.success');

    Route::post('stripe/license-payment', [StripeController::class, 'licensePayment'])->name('stripe.license_payment');
    Route::get('/stripe/license-success-callback', [StripeController::class, 'licenseSuccess'])->name('stripe.license_success');
});


Route::middleware(['auth', config('jetstream.auth_session'), 'verified', LocaleMiddleware::class])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('account_unverified', [DashboardController::class, 'accountUnverified'])->name('account_unverified');

    Route::get('onboarding-steps', [OnboardingStepController::class, 'index'])->name('onboarding_steps');

    Route::resource('menus', MenuController::class);
    Route::resource('menu-items', MenuItemController::class);
    Route::resource('item-categories', ItemCategoryController::class);

    Route::resource('areas', AreaController::class);
    Route::resource('tables', TableController::class);

    Route::get('orders/print/{id}', [OrderController::class, 'printOrder'])->name('orders.print');
    Route::resource('orders', OrderController::class);

    Route::get('pos/order/{id}', [PosController::class, 'order'])->name('pos.order');
    Route::get('pos/kot/{id}', [PosController::class, 'kot'])->name('pos.kot');
    Route::resource('pos', PosController::class);

    Route::resource('kots', KotController::class);

    Route::resource('customers', CustomerController::class);

    Route::resource('settings', RestaurantSettingController::class);

    Route::get('payments/export', fn() => Excel::download(new PaymentExport, 'payments-' . now()->toDateTimeString() . '.xlsx'))->name('payments.export');
    Route::view('payments', 'payments.index')->name('payments.index');
    Route::view('payments/due', 'payments.due')->name('payments.due');
    Route::view('qr-codes', 'qrcodes.index')->name('qrcodes.index');

    Route::resource('reservations', ReservationController::class);

    Route::prefix('reports')->group(function () {
        Route::view('item-report', 'reports.items')->name('reports.item');
        Route::view('category-report', 'reports.category')->name('reports.category');
        Route::view('sales-report', 'reports.sales')->name('reports.sales');
    });

    Route::resource('staff', StaffController::class);

    Route::resource('delivery-executives', DeliveryExecutiveController::class);
    Route::view('billing/upgrade-plan', 'plans.index')->name('pricing.plan');

    Route::get('/pusher/beams-auth', [DashboardController::class, 'beamAuth'])->name('beam_auth');

    Route::resource('waiter-requests', WaiterRequestController::class);

});

Route::middleware(['auth', config('jetstream.auth_session'), 'verified', SuperAdmin::class, LocaleMiddleware::class])->group(function () {

    Route::name('superadmin.')->group(function () {
        Route::get('super-admin-dashboard', [DashboardController::class, 'superadmin'])->name('dashboard');

        Route::resource('restaurants', RestaurantController::class);

        Route::resource('restaurant-payments', RestaurantPaymentController::class);

        Route::resource('packages', PackageController::class);

        Route::resource('invoices', BillingController::class);

        Route::get('offline-plan', [BillingController::class, 'offlinePlanRequests'])->name('offline-plan-request');

        Route::resource('superadmin-settings', SuperadminSettingController::class);

        Route::resource('app-update', GlobalSettingController::class);

        Route::resource('landing-sites', LandingSiteController::class);

    });
});

