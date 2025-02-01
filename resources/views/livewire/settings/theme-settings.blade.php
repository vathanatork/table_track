<div
    class="mx-4 p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
    @if (!in_array('Theme Setting', restaurant_modules()))
    <x-upgrade-box :title="__('modules.settings.themeUpgradeHeading')" :text="__('modules.settings.themeUpgradeInfo')" ></x-upgrade-box>

    @else
    <h3 class="mb-4 text-xl font-semibold dark:text-white">@lang('modules.settings.themeSettings')</h3>

    <form wire:submit="submitForm">
        <div class="grid gap-6">
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
                    <img src="{{ restaurant()->logo_url }}" alt="{{ restaurant()->name }}" class="rounded-md h-20 w-20 object-cover">
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

                @if (restaurant()->logo)
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
                <x-button>@lang('app.save')</x-button>
            </div>
        </div>
    </form>
    @endif
</div>
