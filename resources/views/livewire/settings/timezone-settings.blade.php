<div
    class="mx-4 p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">

    <h3 class="mb-4 text-xl font-semibold dark:text-white">@lang('modules.settings.countryTimezone')</h3>

    <form wire:submit="submitForm">
        <div class="grid gap-6">

            <div>
                <x-label for="restaurantCountry" :value="__('modules.settings.restaurantCountry')" />
                <x-select id="restaurantCountry" class="mt-1 block w-full" wire:model="restaurantCountry">
                    @foreach ($countries as $item)
                    <option value="{{ $item->id }}">{{ $item->countries_name }}</option>
                    @endforeach
                </x-select>
            </div>

            <div>
                <x-label for="restaurantTimezone" :value="__('modules.settings.restaurantTimezone')" />
                <x-select id="restaurantTimezone" class="mt-1 block w-full" wire:model="restaurantTimezone">
                    @foreach ($timezones as $tz)
                        <option value="{{ $tz }}">{{ $tz }}</option>
                    @endforeach
                </x-select>
            </div>

            <div>
                <x-label for="restaurantCurrency" :value="__('modules.settings.restaurantCurrency')" />
                <x-select id="restaurantCurrency" class="mt-1 block w-full" wire:model="restaurantCurrency">
                    @foreach ($currencies as $item)
                        <option value="{{ $item->id }}">{{ $item->currency_name . ' ('.$item->currency_code.')' }}</option>
                    @endforeach
                </x-select>
            </div>

            <div>
                <x-button>@lang('app.save')</x-button>
            </div>
        </div>
    </form>
</div>
