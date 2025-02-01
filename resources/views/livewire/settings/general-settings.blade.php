<div>
    <div
        class="mx-4 p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
        <h3 class="mb-4 text-xl font-semibold dark:text-white">@lang('modules.settings.restaurantInformation')</h3>
        <x-help-text class="mb-6">@lang('modules.settings.generalHelp')</x-help-text>

        <form wire:submit="submitForm">
            <div class="grid gap-6">
                <div>
                    <x-label for="restaurantName" value="{{ __('modules.settings.restaurantName') }}" />
                    <x-input id="restaurantName" class="block mt-1 w-full" type="text"
                        placeholder="{{ __('placeholders.restaurantNamePlaceHolder') }}" autofocus
                        wire:model='restaurantName' />
                    <x-input-error for="restaurantName" class="mt-2" />
                </div>

                <div>
                    <x-label for="restaurantPhoneNumber" value="{{ __('modules.settings.restaurantPhoneNumber') }}" />
                    <x-input id="restaurantPhoneNumber" class="block mt-1 w-full" type="tel"
                        wire:model='restaurantPhoneNumber' />
                    <x-input-error for="restaurantPhoneNumber" class="mt-2" />
                </div>

                <div>
                    <x-label for="restaurantEmailAddress" value="{{ __('modules.settings.restaurantEmailAddress') }}" />
                    <x-input id="restaurantEmailAddress" class="block mt-1 w-full" type="email"
                        wire:model='restaurantEmailAddress' />
                    <x-input-error for="restaurantEmailAddress" class="mt-2" />
                </div>

                <div>
                    <x-label for="restaurantAddress" value="{{ __('modules.settings.restaurantAddress') }}" />
                    <x-textarea class="block mt-1 w-full" wire:model='restaurantAddress' rows='3' />
                    <x-input-error for="restaurantAddress" class="mt-2" />
                </div>

                <div>
                    <x-button>@lang('app.save')</x-button>
                </div>
            </div>
        </form>
    </div>

</div>
