<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ (isRtl() ? 'rtl' : 'ltr') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{global_setting()->logoUrl}}">
    <link rel="manifest" href="{{global_setting()->logoUrl}}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{global_setting()->logoUrl}}">

    <title>{{global_setting()->name}}</title>
    <title>{{global_setting()->logoUrl}}</title>

    @stack('styles')

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles

    @include('sections.theme_style')

    
    @if (file_exists(public_path() . '/css/app-custom.css'))
        <link href="{{ asset('css/app-custom.css') }}" rel="stylesheet">
    @endif


    <script src="https://js.pusher.com/beams/1.0/push-notifications-cdn.js" async></script>

    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }

    </script>

    <script>
        if (localStorage.getItem("menu-collapsed") === "true") {
            document.documentElement.style.visibility = 'hidden';
            window.addEventListener('DOMContentLoaded', () => {
                const sidebar = document.getElementById('sidebar');
                const openIcon = document.getElementById('toggle-sidebar-open');
                const closeIcon = document.getElementById('toggle-sidebar-close');
                
                if (sidebar) {
                    sidebar.classList.add('hidden');
                    sidebar.classList.remove('flex', 'lg:flex');
                }
                
                if (openIcon && closeIcon) {
                    openIcon.classList.remove('hidden');
                    closeIcon.classList.add('hidden');
                }
                
                setTimeout(() => {
                    document.documentElement.style.visibility = 'visible';
                }, 50);
            });
        } else {
            // Handle expanded state icons without hiding the page
            window.addEventListener('DOMContentLoaded', () => {
                const openIcon = document.getElementById('toggle-sidebar-open');
                const closeIcon = document.getElementById('toggle-sidebar-close');
                
                if (openIcon && closeIcon) {
                    openIcon.classList.add('hidden');
                    closeIcon.classList.remove('hidden');
                }
            });
        }
    </script>

</head>

<body class="font-sans antialiased dark:bg-gray-900" id="main-body">

    @if (user()->restaurant_id)
        @livewire('navigation-menu')
    @else
        @livewire('superadmin-navigation-menu')
    @endif

    <div class="flex rtl:flex-row-reverse pt-16 overflow-hidden bg-gray-50 dark:bg-gray-900 h-screen">

        @if (user()->restaurant_id)
            @livewire('sidebar')
        @else
            @livewire('superadmin-sidebar')
        @endif


        <div id="main-content" class="relative w-full h-full overflow-y-auto bg-gray-50 ltr:lg:ml-64 rtl:lg:mr-64 dark:bg-gray-900">
            <main>
                    @yield('content')
                    {{ $slot ?? ''}}
            </main>


        </div>


    </div>

    @stack('modals')


    @livewireScripts
    @include('layouts.update-uri')

    <script src="{{ asset('vendor/livewire-alert/livewire-alert.js') }}" defer data-navigate-track></script>
    <x-livewire-alert::flash />

    @if (user()->restaurant_id)
        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

        @livewire('order.OrderDetail')

        @livewire('customer.addCustomer')

        @livewire('settings.upgradeLicense')

        @livewire('order.addPayment')


        <script src="https://js.stripe.com/v3/"></script>

        <form action="{{ route('stripe.license_payment') }}" method="POST" id="license-payment-form" class="hidden">
            @csrf

            <input type="hidden" id="license_payment" name="license_payment">
            <input type="hidden" id="package_type" name="package_type">
            <input type="hidden" id="package_id" name="package_id">
            <input type="hidden" id="currency_id" name="currency_id">

            <div class="form-row">
                <label for="card-element">
                    Credit or debit card
                </label>
                <div id="card-element">
                    <!-- A Stripe Element will be inserted here. -->
                </div>

                <!-- Used to display Element errors. -->
                <div id="card-errors" role="alert"></div>
            </div>

            <button>Submit Payment</button>
        </form>

        @if (superadminPaymentGateway()->stripe_status)
            <script>
                const stripe = Stripe('{{ superadminPaymentGateway()->stripe_key }}');
                const elements = stripe.elements({
                    currency: '{{ strtolower(restaurant()->currency->currency_code) }}',
                });
            </script>
        @endif

    @endif


    @if (App::environment('codecanyon'))
    <script>
        const currentUserId = "tbltrk-{{ auth()->id() }}"; // Get this from your auth system

        const beamsClient = new PusherPushNotifications.Client({
            instanceId: "{{ pusherSettings()->instance_id }}",
        });

        const beamsTokenProvider = new PusherPushNotifications.TokenProvider({
            url: "{{ route('beam_auth') }}",
        });

        beamsClient.start()
        .then(() => beamsClient.addDeviceInterest('Tabletrack'))
        .then(() => beamsClient.setUserId(currentUserId, beamsTokenProvider))
        .then(() => console.log('Successfully registered and subscribed!'))
        .catch(console.error);

        beamsClient
        .getUserId()
        .then((userId) => {
            console.log(userId, currentUserId);
            // Check if the Beams user matches the user that is currently logged in
            if (userId !== currentUserId) {
            // Unregister for notifications
            return beamsClient.stop();
            }
        })
        .catch(console.error);
    </script>
    @endif

    <script>
        var elem = document.getElementById("main-body");
        function openFullscreen() {
          if (!document.fullscreenElement) {
            if (elem.requestFullscreen) {
              elem.requestFullscreen();
            } else if (elem.webkitRequestFullscreen) { /* Safari */
              elem.webkitRequestFullscreen();
            } else if (elem.msRequestFullscreen) { /* IE11 */
              elem.msRequestFullscreen();
            }
          } else {
            if (document.exitFullscreen) {
              document.exitFullscreen();
            } else if (document.webkitExitFullscreen) { /* Safari */
              document.webkitExitFullscreen();
            } else if (document.msExitFullscreen) { /* IE11 */
              document.msExitFullscreen();
            }
          }
        }
    </script>


    @stack('scripts')
</body>

</html>
