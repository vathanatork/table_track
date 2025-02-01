<div class="max-w-sm w-full mx-auto bg-white dark:bg-gray-700 p-6 rounded-lg h-fit shadow-md">

    @if ($showUserForm)
        <form wire:submit="submitForm">
            @csrf

            <h2 class="text-xl font-medium mb-6 mt-3 dark:text-white">@lang('auth.createAccountSignup', ['appName' => global_setting()->name])</h2>

            <div>
                <x-label for="restaurantName" value="{{ __('Restaurant Name') }}"/>
                <x-input id="restaurantName" class="block mt-1 w-full" type="text" wire:model='restaurantName'/>
                <x-input-error for="restaurantName" class="mt-2"/>
            </div>

            @if(module_enabled('Subdomain'))
                <div class="mt-4">
                    <x-label for="{{ __('subdomain::app.core.subdomain') }}" value="{{ __('subdomain::app.core.subdomain') }}"/>
                <div class="flex items-center mt-1">
                    <!-- Main input field for subdomain, with right border removed -->
                    <x-input id="sub_domain" class="w-full rounded-r-none border-r-0" type="text" name="sub_domain"
                             :value="old('sub_domain')" required autocomplete="sub_domain"
                             type="text"
                             wire:model='sub_domain'
                             placeholder="subdomain"/>

                    <!-- Disabled input field for domain, with left border removed -->
                    @php
                        $domain = function_exists('getDomain') ? getDomain() : $_SERVER['SERVER_NAME'];
                    @endphp
                    <x-input class="w-auto text-gray-500 bg-gray-100 rounded-l-none border-l-0" type="text"
                             :value="'.' . $domain" disabled/>
                </div>
                </div>
            @endif

            <div class="mt-4">
                <x-label for="fullName" value="{{ __('app.fullName') }}"/>
                <x-input id="fullName" class="block mt-1 w-full" type="text" wire:model='fullName'/>
                <x-input-error for="fullName" class="mt-2"/>
            </div>

            <div class="mt-4">
                <x-label for="email" value="{{ __('app.email') }}"/>
                <x-input id="email" class="block mt-1 w-full" type="email" wire:model='email'/>
                <x-input-error for="email" class="mt-2"/>
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('modules.staff.password') }}"/>
                <x-input id="password" class="block mt-1 w-full" type="password" autocomplete="new-password"
                         wire:model='password'/>
                <x-input-error for="password" class="mt-2"/>
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required/>

                            <div class="ms-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <div class="grid items-center grid-cols-1 mt-4 gap-2">
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                   href="{{ route('login') }}">
                    @lang('auth.alreadyRegisteredLoginHere')
                </a>

                <x-button>
                    @lang('modules.restaurant.nextBranchDetails')
                </x-button>
            </div>
        </form>
    @endif

    @if ($showBranchForm)
        <form wire:submit="submitForm2">
            @csrf

            <h2 class="text-xl font-medium mb-6 mt-3 dark:text-white">@lang('modules.restaurant.restaurantBranchDetails')</h2>

            <div>
                <x-label for="branchName" value="{{ __('modules.settings.branchName') }}"/>
                <x-input id="branchName" class="block mt-1 w-full" type="text" wire:model='branchName'/>
                <x-input-error for="branchName" class="mt-2"/>
            </div>

            <div class="mt-4">
                <x-label for="country" value="{{ __('modules.settings.restaurantCountry') }}"/>
                <x-select id="restaurantCountry" class="mt-1 block w-full" wire:model="country">
                    @foreach ($countries as $item)
                        <option value="{{ $item->id }}">{{ $item->countries_name }}</option>
                    @endforeach
                </x-select>
                <x-input-error for="country" class="mt-2"/>
            </div>

            <div class="mt-4">
                <x-label for="address" value="{{ __('modules.settings.branchAddress') }}"/>
                <x-textarea id="address" class="block mt-1 w-full" rows="3" wire:model='address'/>
                <x-input-error for="address" class="mt-2"/>
            </div>

            <div class="lg:grid items-center grid-cols-1 mt-4 gap-2">
                @php($target = 'submitForm2')
                <x-button target="submitForm2">
                    {{ __('auth.signup') }}
                </x-button>
            </div>
        </form>
    @endif

</div>
