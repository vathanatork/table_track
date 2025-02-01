<div
    class="mx-4 p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">

    <h3 class="mb-4 text-xl font-semibold dark:text-white">@lang('modules.settings.customerSiteSettings')</h3>

    <form wire:submit="submitForm">
        <div class="grid gap-6">

            <div class="cursor-pointer">
                <x-label for="customerLoginRequired" :value="__('modules.settings.customerLoginRequired')" />
                <x-checkbox name="customerLoginRequired" id="customerLoginRequired" wire:model='customerLoginRequired'  />
            </div>

            <div class="cursor-pointer">
                <x-label for="allowCustomerOrders" :value="__('modules.settings.allowCustomerOrders')" />
                <x-checkbox name="allowCustomerOrders" id="allowCustomerOrders" wire:model.live='allowCustomerOrders'  />
            </div>

            <div class="cursor-pointer">
                <x-label for="allowCustomerDeliveryOrders" :value="__('modules.settings.allowCustomerDeliveryOrders')" />
                <x-checkbox name="allowCustomerDeliveryOrders" id="allowCustomerDeliveryOrders" wire:model='allowCustomerDeliveryOrders'  />
            </div>

            <div class="cursor-pointer">
                <x-label for="allowCustomerPickupOrders" :value="__('modules.settings.allowCustomerPickupOrders')" />
                <x-checkbox name="allowCustomerPickupOrders" id="allowCustomerPickupOrders" wire:model='allowCustomerPickupOrders'  />
            </div>

            <div class="cursor-pointer">
                <x-label for="isWaiterRequestEnabled" :value="__('modules.settings.isWaiterRequestEnabled')" />
                <x-checkbox name="isWaiterRequestEnabled" id="isWaiterRequestEnabled" wire:model='isWaiterRequestEnabled'  />
            </div>

            <div class="cursor-pointer">
                <x-label for="tableRequired" :value="__('modules.settings.tableRequiredDineIn')" />
                <x-checkbox name="tableRequired" id="tableRequired" wire:model='tableRequired'  />
            </div>

            <div class="cursor-pointer">
                <x-label for="defaultReservationStatus" :value="__('modules.settings.defaultReservationStatus')" />
                <select id="defaultReservationStatus" wire:model="defaultReservationStatus" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="Confirmed">@lang('modules.settings.reservationStatusConfirmed')</option>
                    <option value="Pending">@lang('modules.settings.reservationStatusPending')</option>
                    <option value="Checked_In">@lang('modules.settings.reservationStatusCheckedIn')</option>
                    <option value="Cancelled">@lang('modules.settings.reservationStatusCancelled')</option>
                    <option value="No_Show">@lang('modules.settings.reservationStatusNoShow')</option>
                </select>
            </div>

            <div>
                    <x-label for="facebook" value="{{ __('modules.settings.facebook_link') }}" />
                    <x-input id="facebook" class="block mt-1 w-full" type="url"
                        placeholder="{{ __('placeholders.facebookPlaceHolder') }}" autofocus
                        wire:model='facebook' />
                    <x-input-error for="facebook" class="mt-2" />
                </div>

                 <div>
                    <x-label for="instagram" value="{{ __('modules.settings.instagram_link') }}" />
                    <x-input id="instagram" class="block mt-1 w-full" type="url"
                        placeholder="{{ __('placeholders.instagramPlaceHolder') }}" autofocus
                        wire:model='instagram' />
                    <x-input-error for="instagram" class="mt-2" />
                </div>

                 <div>
                    <x-label for="twitter" value="{{ __('modules.settings.twitter_link') }}" />
                    <x-input id="twitter" class="block mt-1 w-full" type="url"
                        placeholder="{{ __('placeholders.twitterPlaceHolder') }}" autofocus
                        wire:model='twitter' />
                    <x-input-error for="twitter" class="mt-2" />
                </div>

            <div>
                <x-button>@lang('app.save')</x-button>
            </div>
        </div>
    </form>
</div>
