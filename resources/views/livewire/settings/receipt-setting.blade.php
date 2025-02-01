<div
    class="mx-4 p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">

    <h3 class="mb-4 text-xl font-semibold dark:text-white">@lang('modules.settings.receiptSetting')</h3>

    <form wire:submit="submitForm">
        <div class="grid gap-6">

            
            <div>
                <x-label for="customerName">
                    <div class="flex items-center cursor-pointer">
                        <x-checkbox name="customerName" id="customerName" wire:model='customerName'/>

                        <div class="ms-2">
                            @lang('modules.settings.customerName')
                        </div>
                    </div>
                </x-label>
            </div>

            <div>
                <x-label for="customerAddress">
                    <div class="flex items-center cursor-pointer">
                        <x-checkbox name="customerAddress" id="customerAddress" wire:model='customerAddress' />

                        <div class="ms-2">
                            @lang('modules.settings.customerAddress')
                        </div>
                    </div>
                </x-label>
            </div>

            <div>
                <x-label for="tableNumber">
                    <div class="flex items-center cursor-pointer">
                        <x-checkbox name="tableNumber" id="tableNumber" wire:model='tableNumber' />

                        <div class="ms-2">
                            @lang('modules.settings.tableNumber')
                        </div>
                    </div>
                </x-label>
            </div>
            <div class="hidden">
                <x-label for="paymentQrCode">
                    <div class="flex items-center cursor-pointer">
                        <x-checkbox name="paymentQrCode" id="paymentQrCode" wire:model='paymentQrCode' />

                        <div class="ms-2">
                            @lang('modules.settings.paymentQrCode')
                        </div>
                    </div>
                </x-label>
            </div>
            <div>
                <x-label for="waiter">
                    <div class="flex items-center cursor-pointer">
                        <x-checkbox name="waiter" id="waiter" wire:model='waiter' />

                        <div class="ms-2">
                            @lang('modules.settings.waiter')
                        </div>
                    </div>
                </x-label>
            </div>
            <div>
                <x-label for="totalGuest">
                    <div class="flex items-center cursor-pointer">
                        <x-checkbox name="totalGuest" id="totalGuest" wire:model='totalGuest' />

                        <div class="ms-2">
                            @lang('modules.settings.totalGuest')
                        </div>
                    </div>
                </x-label>
            </div>
            <div>
                <x-label for="restaurantLogo">
                    <div class="flex items-center cursor-pointer">
                        <x-checkbox name="restaurantLogo" id="restaurantLogo" wire:model='restaurantLogo' />

                        <div class="ms-2">
                            @lang('modules.settings.restaurantLogo')
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
