<div>
    <div
        class="mx-4 p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">

        @if (!in_array('Payment Gateway Integration', restaurant_modules()))
        <x-upgrade-box :title="__('modules.settings.paymentUpgradeHeading')" :text="__('modules.settings.paymentUpgradeInfo')" ></x-upgrade-box>

        @else
            <h3 class="mb-4 text-xl font-semibold dark:text-white">@lang('modules.settings.paymentgatewaySettings')</h3>
            <x-help-text class="mb-6">@lang('modules.settings.paymentHelp')</x-help-text>

            <div class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
                <ul class="flex flex-wrap -mb-px items-center">
                    <li class="me-2">
                        <span wire:click="activeSetting('razorpay')" @class(["inline-flex items-center gap-x-1 cursor-pointer select-none p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300", 'border-transparent' => ($activePaymentSetting != 'razorpay'), 'active border-skin-base dark:text-skin-base dark:border-skin-base text-skin-base' => ($activePaymentSetting == 'razorpay')])>
                            <svg class="h-4 w-4" width="24" height="24" viewBox="0 0 24 24"><defs><linearGradient id="a" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#0d3e8e"/><stop offset="100%" stop-color="#00c3f3"/></linearGradient></defs><path fill="url(#a)" d="m22.436 0-11.91 7.773-1.174 4.276 6.625-4.297L11.65 24h4.391z"/><path fill="#0D3E8E" d="M14.26 10.098 3.389 17.166 1.564 24h9.008z"/></svg>
                            @lang('modules.billing.razorpay')
                            <span @class(['flex w-3 h-3 me-3 rounded-full','bg-green-500' => $isRazorpayEnabled, 'bg-red-500' => !$isRazorpayEnabled  ])></span>
                        </span>
                    </li>

                    <li wire:click="activeSetting('stripe')" class="me-2">
                        <span @class(["inline-flex items-center gap-x-1 cursor-pointer select-none p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300", 'border-transparent' => ($activePaymentSetting != 'stripe'), 'active border-skin-base dark:text-skin-base dark:border-skin-base text-skin-base' => ($activePaymentSetting == 'stripe')])>
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="24" height="24" fill="#6772e5"><path d="M111.328 15.602c0-4.97-2.415-8.9-7.013-8.9s-7.423 3.924-7.423 8.863c0 5.85 3.32 8.8 8.036 8.8 2.318 0 4.06-.528 5.377-1.26V19.22a10.25 10.25 0 0 1-4.764 1.075c-1.9 0-3.556-.67-3.774-2.943h9.497a40 40 0 0 0 .063-1.748zm-9.606-1.835c0-2.186 1.35-3.1 2.56-3.1s2.454.906 2.454 3.1zM89.4 6.712a5.43 5.43 0 0 0-3.801 1.509l-.254-1.208h-4.27v22.64l4.85-1.032v-5.488a5.43 5.43 0 0 0 3.444 1.265c3.472 0 6.64-2.792 6.64-8.957.003-5.66-3.206-8.73-6.614-8.73zM88.23 20.1a2.9 2.9 0 0 1-2.288-.906l-.03-7.2a2.93 2.93 0 0 1 2.315-.96c1.775 0 2.998 2 2.998 4.528.003 2.593-1.198 4.546-2.995 4.546zM79.25.57l-4.87 1.035v3.95l4.87-1.032z" fill-rule="evenodd"/><path d="M74.38 7.035h4.87V24.04h-4.87z"/><path d="m69.164 8.47-.302-1.434h-4.196V24.04h4.848V12.5c1.147-1.5 3.082-1.208 3.698-1.017V7.038c-.646-.232-2.913-.658-4.048 1.43zm-9.73-5.646L54.698 3.83l-.02 15.562c0 2.87 2.158 4.993 5.038 4.993 1.585 0 2.756-.302 3.405-.643v-3.95c-.622.248-3.683 1.138-3.683-1.72v-6.9h3.683V7.035h-3.683zM46.3 11.97c0-.758.63-1.05 1.648-1.05a10.9 10.9 0 0 1 4.83 1.25V7.6a12.8 12.8 0 0 0-4.83-.888c-3.924 0-6.557 2.056-6.557 5.488 0 5.37 7.375 4.498 7.375 6.813 0 .906-.78 1.186-1.863 1.186-1.606 0-3.68-.664-5.307-1.55v4.63a13.5 13.5 0 0 0 5.307 1.117c4.033 0 6.813-1.992 6.813-5.485 0-5.796-7.417-4.76-7.417-6.943zM13.88 9.515c0-1.37 1.14-1.9 2.982-1.9A19.66 19.66 0 0 1 25.6 9.876v-8.27A23.2 23.2 0 0 0 16.862.001C9.762.001 5 3.72 5 9.93c0 9.716 13.342 8.138 13.342 12.326 0 1.638-1.4 2.146-3.37 2.146-2.905 0-6.657-1.202-9.6-2.802v8.378A24.4 24.4 0 0 0 14.973 32C22.27 32 27.3 28.395 27.3 22.077c0-10.486-13.42-8.613-13.42-12.56z" fill-rule="evenodd"/></svg>
                            @lang('modules.billing.stripe')
                            <span @class(['flex w-3 h-3 me-3 rounded-full','bg-green-500' => $isStripeEnabled, 'bg-red-500' => !$isStripeEnabled ])></span>
                        </span>
                    </li>

                    <li wire:click="activeSetting('serviceSpecific')" class="me-2">
                        <span @class(["inline-flex items-center gap-x-1 cursor-pointer select-none p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300", 'border-transparent' => ($activePaymentSetting != 'serviceSpecific'), 'active border-skin-base dark:text-skin-base dark:border-skin-base text-skin-base' => ($activePaymentSetting == 'serviceSpecific')])>
                            <svg class="w-5 h-5 current-Color" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M20 6H10m0 0a2 2 0 1 0-4 0m4 0a2 2 0 1 1-4 0m0 0H4m16 6h-2m0 0a2 2 0 1 0-4 0m4 0a2 2 0 1 1-4 0m0 0H4m16 6H10m0 0a2 2 0 1 0-4 0m4 0a2 2 0 1 1-4 0m0 0H4"/></svg>
                            @lang('modules.billing.generalSettings')
                        </span>
                    </li>

                </ul>
            </div>

            @if($activePaymentSetting == 'razorpay')
            <form wire:submit="submitFormRazorpay">
                <div class="grid gap-6">

                    <div class="my-3">
                        <x-label for="razorpayStatus">
                            <div class="flex items-center cursor-pointer">
                                <x-checkbox name="razorpayStatus" id="razorpayStatus" wire:model.live='razorpayStatus' />

                                <div class="ms-2">
                                    @lang('modules.settings.enableRazorpay')
                                </div>
                            </div>
                        </x-label>
                    </div>

                    @if ($razorpayStatus)
                    <div>
                        <x-label for="razorpayKey" value="Razorpay KEY" />
                        <x-input id="razorpayKey" class="block mt-1 w-full" type="text" wire:model='razorpayKey' />
                        <x-input-error for="razorpayKey" class="mt-2" />
                    </div>

                    <div>
                        <x-label for="razorpaySecret" value="Razorpay SECRET" />
                        <x-input id="razorpaySecret" class="block mt-1 w-full" type="text" wire:model='razorpaySecret' />
                        <x-input-error for="razorpaySecret" class="mt-2" />
                    </div>
                    @endif

                    <div>
                        <x-button>@lang('app.save')</x-button>
                    </div>
                </div>
            </form>
            @endif

            <!-- Stripe Form -->
            @if($activePaymentSetting == 'stripe')
            <form wire:submit="submitFormStripe">
                <div class="grid gap-6">
                    <div class="my-3">
                        <x-label for="stripeStatus">
                            <div class="flex items-center cursor-pointer">
                                <x-checkbox name="stripeStatus" id="stripeStatus" wire:model.live='stripeStatus'/>

                                <div class="ms-2">
                                    @lang('modules.settings.enableStripe')
                                </div>
                            </div>
                        </x-label>
                    </div>

                    @if ($stripeStatus)
                        <div>
                            <x-label for="stripeKey" value="Stripe KEY" />
                            <x-input id="stripeKey" class="block mt-1 w-full" type="text" wire:model='stripeKey' />
                            <x-input-error for="stripeKey" class="mt-2" />
                        </div>

                        <div>
                            <x-label for="stripeSecret" value="Stripe SECRET" />
                            <x-input id="stripeSecret" class="block mt-1 w-full" type="text" wire:model='stripeSecret' />
                            <x-input-error for="stripeSecret" class="mt-2" />
                        </div>
                    @endif

                    <div>
                        <x-button>@lang('app.save')</x-button>
                    </div>
                </div>
            </form>
            @endif

            @if($activePaymentSetting == 'serviceSpecific')
            @if($isRazorpayEnabled || $isStripeEnabled)

            <x-alert type="info" class="my-4">
                @lang('modules.settings.generalSettingsUseInfo')
            </x-alert>

            <form wire:submit="submitFormServiceSpecific">
                <!-- Service-Specific Toggles -->

                <div class="mt-6">
                    <div class="space-y-3">
                        <x-label for="enableForDineIn">
                            <div class="flex items-center cursor-pointer">
                                <x-checkbox name="enableForDineIn" id="enableForDineIn" wire:model='enableForDineIn' />

                                <div class="ms-2">
                                    @lang('modules.settings.dineInOnlinePaymentRequired')
                                </div>
                            </div>
                        </x-label>
                        <x-label for="enableForDelivery">
                            <div class="flex items-center cursor-pointer">
                                <x-checkbox name="enableForDelivery" id="enableForDelivery" wire:model='enableForDelivery' />

                                <div class="ms-2">
                                    @lang('modules.settings.deliveryOnlinePaymentRequired')
                                </div>
                            </div>
                        </x-label>
                        <x-label for="enableForPickup">
                            <div class="flex items-center cursor-pointer">
                                <x-checkbox name="enableForPickup" id="enableForPickup" wire:model='enableForPickup' />

                                <div class="ms-2">
                                    @lang('modules.settings.pickupOnlinePaymentRequired')
                                </div>
                            </div>
                        </x-label>
                    </div>
                </div>
                <div class="mt-4">
                    <x-button>@lang('app.save')</x-button>
                </div>
            </form>
            @else
            <x-alert type="info" class="my-4">
                @lang('modules.settings.enableRazorpayOrStripe')
            </x-alert>

            @endif
            @endif

        @endif
    </div>

</div>
