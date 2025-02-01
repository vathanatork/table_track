<div>

    @if ($showUserForm)
        <form wire:submit="submitForm">
            @csrf

            <div>
                <x-label for="restaurantName" value="{{ __('Restaurant Name') }}" />
                <x-input id="restaurantName" class="block mt-1 w-full" type="text" wire:model='restaurantName' />
                <x-input-error for="restaurantName" class="mt-2" />
            </div>

            @if (module_enabled('Subdomain'))
                <div class="mt-4">
                    <x-label for="{{ __('subdomain::app.core.subdomain') }}"
                        value="{{ __('subdomain::app.core.subdomain') }}" />
                    <div class="flex items-center mt-1">
                        <!-- Main input field for subdomain, with right border removed -->
                        <x-input id="sub_domain" class="w-full rounded-r-none border-r-0" type="text"
                            name="sub_domain" :value="old('sub_domain')" required autocomplete="sub_domain" type="text"
                            wire:model='sub_domain' placeholder="subdomain" />

                        <!-- Disabled input field for domain, with left border removed -->
                        @php
                            $domain = function_exists('getDomain') ? getDomain() : $_SERVER['SERVER_NAME'];
                        @endphp
                        <x-input class="w-auto text-gray-500 bg-gray-100 rounded-l-none border-l-0" type="text"
                            :value="'.' . $domain" disabled />
                    </div>
                </div>
            @endif

            <div class="mt-4">
                <x-label for="fullName" value="{{ __('Your Full Name') }}" />
                <x-input id="fullName" class="block mt-1 w-full" type="text" wire:model='fullName' />
                <x-input-error for="fullName" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-label for="email" value="{{ __('app.email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" wire:model='email' />
                <x-input-error for="email" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" autocomplete="new-password"
                    wire:model='password' />
                <x-input-error for="password" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-label for="facebook" value="{{ __('Facebook Link') }}" />
                <x-input id="facebook" class="block mt-1 w-full" type="url"
                   autofocus wire:model='facebook' />
                <x-input-error for="facebook" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-label for="instagram" value="{{ __('Instagram Link') }}" />
                <x-input id="instagram" class="block mt-1 w-full" type="url"
                    autofocus wire:model='instagram' />
                <x-input-error for="instagram" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-label for="twitter" value="{{ __('Twitter Link') }}" />
                <x-input id="twitter" class="block mt-1 w-full" type="url"
                   autofocus wire:model='twitter' />
                <x-input-error for="twitter" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-label for="status" value="{{ __('app.status') }}" />
                <x-select id="status" class="mt-1 block w-full" wire:model="status">
                    <option value="1">{{ __('app.active') }}</option>
                    <option value="0">{{ __('app.inactive') }}</option>
                </x-select>
                <x-input-error for="status" class="mt-2" />
            </div>

            <div class="lg:flex items-center justify-between mt-4 gap-2">


                <x-button>
                    {{ __('Next: Branch Details') }}
                </x-button>
            </div>
        </form>
    @endif

    @if ($showBranchForm)
        <form wire:submit="submitForm2">
            @csrf

            <h2 class="text-xl font-medium mb-6 mt-3 dark:text-white">@lang('modules.restaurant.restaurantBranchDetails')</h2>

            <div>
                <x-label for="branchName" value="{{ __('Branch Name') }}" />
                <x-input id="branchName" class="block mt-1 w-full" type="text" wire:model='branchName' />
                <x-input-error for="branchName" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-label for="country" value="{{ __('Country') }}" />
                <x-select id="restaurantCountry" class="mt-1 block w-full" wire:model="country">
                    @foreach ($countries as $item)
                        <option value="{{ $item->id }}">{{ $item->countries_name }}</option>
                    @endforeach
                </x-select>
                <x-input-error for="country" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-label for="address" value="{{ __('Address') }}" />
                <x-textarea id="address" class="block mt-1 w-full" rows="3" wire:model='address' />
                <x-input-error for="address" class="mt-2" />
            </div>

            <div class="flex items-center justify-between mt-4">
                <x-button wire:target="submitForm2" wire:loading.attr="disabled">
                    @lang('app.save')
                </x-button>
            </div>
        </form>
    @endif

</div>
