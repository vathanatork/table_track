<div
    class="mx-4 p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">

    <x-cron-message />

    <h3 class="mb-4 text-xl font-semibold dark:text-white">@lang('modules.settings.appSettings')</h3>

    <form wire:submit.prevent="submitForm">
        <div class="grid gap-6">
            <div class="grid lg:grid-cols-3 gap-6">

                <div>
                    <x-label for="appName" value="{{ __('modules.settings.appName') }}" />
                    <x-input id="appName" class="block mt-1 w-full" type="text" autofocus wire:model='appName' />
                    <x-input-error for="appName" class="mt-2" />
                </div>

            
                <div>
                    <x-label for="defaultLanguage" value="{{ __('modules.settings.defaultLanguage') }}" />
                    <x-select id="defaultLanguage" class="block mt-1 w-full" wire:model='defaultLanguage'>
                        @foreach ($languageSettings as $item)
                            <option value="{{ $item->language_code }}">{{  isset(\App\Models\LanguageSetting::LANGUAGES_TRANS[$item->language_code]) ? \App\Models\LanguageSetting::LANGUAGES_TRANS[$item->language_code] . ' (' . $item->language_name . ')' : $item->language_name }}</option>
                        @endforeach
                    </x-select>

                    <x-input-error for="defaultLanguage" class="mt-2" />
                </div>

                <div>
                    <x-label for="defaultCurrency" value="{{ __('modules.settings.defaultCurrency') }}" />
                    <x-select id="defaultCurrency" class="block mt-1 w-full" wire:model='defaultCurrency'>
                        @foreach ($globalCurrencies as $item)
                            <option value="{{ $item->id }}">{{ $item->currency_name . ' (' . $item->currency_code . ')' }}</option>
                        @endforeach
                    </x-select>

                    <x-input-error for="defaultCurrency" class="mt-2" />
                </div>
            </div>
            <div x-data="{photoName: null, photoPreview: null}">
                <!-- Profile Photo File Input -->
                <input type="file" id="photo" class="hidden" accept="image/png, image/gif, image/jpeg, image/webp"
                            wire:model.live="photo"
                            x-ref="photo"
                            x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

                <x-label for="photo" value="{{ __('app.logo') }}" />

                <!-- Current Profile Photo -->
                <div class="mt-2" x-show="! photoPreview">
                    <img src="{{ $settings->logo_url }}" alt="{{ $settings->name }}" class="rounded-md h-20 w-20 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" x-show="photoPreview" style="display: none;">
                    <span class="block rounded-md w-20 h-20 bg-cover bg-no-repeat bg-center"
                          x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <x-secondary-button class="mt-2 me-2" type="button" x-on:click.prevent="$refs.photo.click()">
                    {{ __('modules.settings.uploadLogo') }}
                </x-secondary-button>

                @if ($settings->logo)
                    <x-secondary-button type="button" class="mt-2" wire:click="deleteLogo">
                        {{ __('modules.settings.removeLogo') }}
                    </x-secondary-button>
                @endif

                <x-input-error for="logo" class="mt-2" />
            </div>

            <div>
                <x-label for="themeColor" value="{{ __('modules.settings.themeColor') }}" />

                <input type="color" class="p-1 h-10 w-14 block bg-white border border-gray-200 cursor-pointer rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700" id="hs-color-input" title="Choose your color"  wire:model='themeColor'>

                <x-input-error for="themeColor" class="mt-2" />
            </div>

           <div>
                <x-label for="requiresApproval">
                    <div class="flex items-start gap-3">
                        <x-checkbox class="mt-1" name="requiresApproval" id="requiresApproval" wire:model='requiresApproval' />

                        <div class="flex flex-col">
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">
                                @lang('modules.settings.restaurantRequiresApproval')
                            </span>
                            <span class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                @lang('modules.settings.restaurantRequiresApprovalInfo')
                            </span>
                        </div>
                    </div>
                </x-label>
            </div>

            <div>
                <x-button>@lang('app.save')</x-button>
            </div>
        </div>
    </form>

</div>
