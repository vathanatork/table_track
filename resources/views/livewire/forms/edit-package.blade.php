<div>
    <div class="mb-4 col-span-full xl:mb-2">
        <nav class="flex mb-5" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
            <li class="inline-flex items-center">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                @lang('menu.dashboard')
                </a>
            </li>
            <li>
                <div class="flex items-center">
                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                <a href="{{ route('superadmin.packages.index') }}" class="ml-1 text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-300 dark:hover:text-white">@lang('menu.packages')</a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page">@lang('modules.package.editPackage')</span>
                </div>
            </li>
        </ol>
    </nav>
    </div>

    @if($showPackageDetailsForm)
        <div class="mb-4">
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">@lang('modules.package.editPackage')</h1>
        </div>
        <form wire:submit="submitForm">
            @csrf

            @if($packageType->isEditable())
                <div>
                    <ul class="flex items-center w-full mb-4 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg md:w-1/2 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <li class="w-full border-b border-gray-200 cursor-pointer sm:border-b-0 sm:border-r dark:border-gray-600">
                            <div class="flex items-center ps-3">
                                <input id="horizontal-list-radio-delivery" wire:model.live='isFree' type="radio" value="0"
                                    name="list-radio" class="w-4 h-4 bg-gray-100 border-gray-300 text-skin-base focus:ring-skin-base dark:focus:ring-skin-base dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                <label for="horizontal-list-radio-delivery" class="w-full py-2 text-sm font-medium text-gray-900 ms-2 dark:text-gray-300">@lang('modules.package.paidPlan')</label>
                            </div>
                        </li>
                        <li class="w-full border-b border-gray-200 sm:border-b-0 dark:border-gray-600">
                            <div class="flex items-center ps-3">
                                <input id="horizontal-list-radio-dine_in" wire:model.live='isFree' type="radio" value="1"
                                    name="list-radio" class="w-4 h-4 bg-gray-100 border-gray-300 text-skin-base focus:ring-skin-base dark:focus:ring-skin-base dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                <label for="horizontal-list-radio-dine_in" class="w-full py-2 text-sm font-medium text-gray-900 ms-2 dark:text-gray-300">@lang('modules.package.freePlan')</label>
                            </div>
                        </li>
                    </ul>
                </div>
            @endif

            <div>
                <x-label for="packageName" value="{{ __('modules.package.packageName') }}" />
                <x-input id="packageName" class="block w-full mt-1" type="text" wire:model='packageName' />
                <x-input-error for="packageName" class="mt-2" />
            </div>

            @if(!$isFree)
                <div class="mt-4">
                    <x-label for="status" value="{{ __('modules.package.choosePackageType') }}" />
                    <x-select id="status" class="block w-full mt-1" wire:model.live="packageType">
                        @foreach($packageTypes as $type)
                        <option value="{{ $type->value }}">{{ $type->label() }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error for="packageType" class="mt-2" />
                </div>
            @endif

            @if($packageType->isEditable())
                <div class="grid grid-cols-2 mt-4">
                    <x-label for="isRecommended">
                        <div class="flex items-center cursor-pointer">
                            <x-checkbox name="isRecommended" id="isRecommended" wire:model="isRecommended" />
                            <div class="select-none ms-2">
                                @lang('modules.package.isRecommended')
                            </div>
                        </div>
                    </x-label>

                    <x-label for="isPrivate">
                        <div class="flex items-center cursor-pointer">
                            <x-checkbox name="isPrivate" id="isPrivate" wire:model="isPrivate" />
                            <div class="select-none ms-2">
                                @lang('modules.package.isPrivate')
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            @if($packageType != App\Enums\PackageType::TRIAL)
                <div class="mt-4">
                    <x-label for="sortOrder" value="Sort Order" />
                    <x-select id="sortOrder" class="block w-full mt-1" wire:model="sortOrder">
                        @foreach (range(1, $maxOrder) as $i)
                        <option value="{{ $i }}">{{ $i }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error for="sortOrder" />
                </div>
            @endif

            @if(!$isFree)
                <hr class="h-px my-4 bg-gray-200 border-0 dark:bg-gray-700" />

                <div class="mt-4">
                    <x-label for="currencyID" value="{{ __('Currency') }}" />
                    <x-select id="currencyID" class="block readonly w-full mt-1" wire:model.live="currencyID" disabled>
                        @foreach($currencies as $currency)
                        <option value="{{ $currency->id }}">{{ $currency->currency_symbol }} ({{ $currency->currency_code }})
                        </option>
                        @endforeach
                    </x-select>
                    <x-input-error for="currencyID" class="mt-2" />
                </div>

                @if($packageType == App\Enums\PackageType::LIFETIME)
                    <div class="mt-4">
                        <x-label for="price" value="{{ __('Life Time Plan Price ') . ' (' . $currencySymbol . ') '  }}" />
                        <x-input id="price" class="block w-full mt-1" type="number" min="0" wire:model="price" />
                        <x-input-error for="price" class="mt-2" />
                    </div>
                @else
                    <div class="grid grid-cols-2 mt-4 gap-x-3 md:gap-x-5">
                        <x-label for="monthlyStatus">
                            <div class="flex items-center cursor-pointer">
                                <x-checkbox name="monthlyStatus" id="monthlyStatus" wire:model.live="monthlyStatus" />
                                <div class="select-none ms-2">
                                    @lang('modules.package.monthlyPlan')
                                </div>
                            </div>
                        </x-label>

                        <x-label for="annualStatus">
                            <div class="flex items-center cursor-pointer">
                                <x-checkbox name="annualStatus" id="annualStatus" wire:model.live="annualStatus" />
                                <div class="select-none ms-2">
                                    @lang('modules.package.annualPlan')
                                </div>
                            </div>
                        </x-label>
                    </div>
                @endif

                <div class="grid grid-cols-1 gap-4 mt-4 sm:grid-cols-2">
                    @if($monthlyStatus)
                        <div class="{{ $annualStatus ? 'col-span-1' : 'col-span-2' }} transition-all">
                            <div>
                                <x-label for="monthlyPrice"
                                    value="{{ __('modules.package.monthlyPrice') . ' (' . $currencySymbol . ') ' }}" required="true" />
                                <x-input id="monthlyPrice" class="block w-full mt-1" step="0.01" type="number" min="0" wire:model="monthlyPrice" />
                                <x-input-error for="monthlyPrice" class="mt-2" />
                            </div>
                            @if($paymentKey->stripe_status == 1)
                                <div>
                                    <x-label for="stripeMonthlyPlanId"
                                        value="{{ __('modules.package.monthlyStripeId') }}" required="true" />
                                    <x-input id="stripeMonthlyPlanId" class="block w-full mt-1" type="text" min="0" wire:model="stripeMonthlyPlanId" />
                                    <x-input-error for="stripeMonthlyPlanId" class="mt-2" />
                                </div>
                            @endif

                            @if($paymentKey->razorpay_status == 1)
                                <div>
                                    <x-label for="razorpayMonthlyPlanId"
                                        value="{{ __('modules.package.monthlyRazorpayId') }}" required="true" />
                                    <x-input id="razorpayMonthlyPlanId" class="block w-full mt-1" type="text" min="0" wire:model="razorpayMonthlyPlanId" />
                                    <x-input-error for="razorpayMonthlyPlanId" class="mt-2" />
                                </div>
                            @endif
                        </div>
                    @endif

                    @if($annualStatus)
                        <div class="{{ $monthlyStatus ? 'col-span-1' : 'col-span-2' }} transition-all">
                            <div>
                                <x-label for="annualPrice"
                                    value="{{ __('modules.package.annualPrice') . ' (' . $currencySymbol . ') ' }}" required="true"/>
                                <x-input id="annualPrice" class="block w-full mt-1" step="0.01" type="number" min="0" wire:model="annualPrice" />
                                <x-input-error for="annualPrice" class="mt-2" />
                            </div>
                            @if($paymentKey->stripe_status == 1)
                                <div>
                                    <x-label for="stripeAnnualPlanId"
                                        value="{{ __('modules.package.annualStripeId') }}" required="true"/>
                                    <x-input id="stripeAnnualPlanId" class="block w-full mt-1" type="text" min="0" wire:model="stripeAnnualPlanId" />
                                    <x-input-error for="stripeAnnualPlanId" class="mt-2" />
                                </div>
                            @endif
                            @if($paymentKey->razorpay_status == 1)
                                <div>
                                    <x-label for="razorpayAnnualPlanId"
                                        value="{{ __('modules.package.annualRazorpayId') }}" required="true" />
                                    <x-input id="razorpayAnnualPlanId" class="block w-full mt-1" type="text" min="0" wire:model="razorpayAnnualPlanId" />
                                    <x-input-error for="razorpayAnnualPlanId" class="mt-2" />
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            @endif

            @if ($packageType == App\Enums\PackageType::TRIAL)
                <div class="grid grid-cols-1 gap-4 mt-4 sm:grid-cols-2">
                    <div class="mt-4">
                        <x-label for="trialStatus" value="{{ __('modules.package.trialStatus') }}" />
                        <x-select id="trialStatus" class="block w-full mt-1" wire:model="trialStatus">
                            <option value="1">{{ __('app.active') }}</option>
                            <option value="0">{{ __('app.inactive') }}</option>
                        </x-select>
                        <x-input-error for="trialStatus" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-label for="trialNotificationBeforeDays" value="{{ __('modules.package.NotificationBeforeDays') }}" />
                        <x-input id="trialNotificationBeforeDays" class="block w-full mt-1 " type="number" wire:model='trialNotificationBeforeDays' />
                        <x-input-error for="trialNotificationBeforeDays" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-label for="trialDays" value="{{ __('modules.package.trialDays') }}" />
                        <x-input id="trialDays" class="block w-full mt-1" type="number" wire:model='trialDays' />
                        <x-input-error for="trialDays" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-label for="trialMessage" value="{{ __('modules.package.trialMessage') }}" />
                        <x-input id="trialMessage" type="text" class="block w-full mt-1" wire:model='trialMessage' />
                        <x-input-error for="trialMessage" class="mt-2" />
                    </div>
                </div>
            @endif

            <hr class="h-px my-5 bg-gray-200 border-0 dark:bg-gray-700">
            <div class="mt-4">
                <x-label for="selectModules" value="{{ __('modules.package.selectModules') }}" />

                <x-label class="my-4 inline-flex items-center cursor-pointer class=" for="toggleSelectAll">
                    <x-checkbox name="toggleSelectAll" id="toggleSelectAll" wire:model.live="toggleSelectedModules" />
                    <div class="select-none ms-2">
                        @lang('modules.package.selectAll')
                    </div>
                </x-label>

                <div id="selectModules" class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($modules as $module)
                        <div class="flex items-center space-x-3 select-none">
                            <x-checkbox
                                id="module_{{ $module->id }}"
                                wire:model="selectedModules"
                                value="{{ $module->id }}"
                            />
                            <label for="module_{{ $module->id }}" class="text-sm font-medium text-gray-900 cursor-pointer dark:text-gray-300">
                                {{ $module->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
                <x-input-error for="selectedModules" class="mt-2" />
            </div>

            <div class="mt-6">
                <x-label for="selectFeatures" value="{{ __('modules.package.selectAdditionalFeature') }}" />

                <div id="selectAdditionalFeatures" class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 mt-2">
                    @foreach($additionalFeatures as $feature)
                        <div class="flex items-center space-x-3 select-none">
                            <x-checkbox
                                id="feature_{{ $loop->index }}"
                                wire:model.live="selectedFeatures"
                                value="{{ $feature }}"
                            />
                            <label for="feature_{{ $loop->index }}" class="text-sm font-medium text-gray-900 cursor-pointer dark:text-gray-300">
                                {{ ucwords(str_replace('_', ' ', $feature)) }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            @if(in_array('Change Branch', $selectedFeatures))
                <div class="mt-4">
                    <x-alert type="warning">
                        <svg class="w-5 h-5 text-current me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11h2v5m-2 0h4m-2.592-8.5h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                        @lang('modules.package.branchLimitInfo')
                    </x-alert>
                    <x-label for="branch_limit" value="{{ __('modules.package.branchLimit') }}" />
                    <x-input id="branch_limit" class="block w-full mt-1" type="number" wire:model.live='branchLimit' />
                    <x-input-error for="branchLimit" class="mt-2" />
                </div>
            @endif

            <div class="mt-2">
                <x-label for="description" value="{{ __('modules.package.description') }}" />
                <x-textarea id="description" rows="3" class="block w-full mt-1" wire:model='description' />
                <x-input-error for="description" class="mt-2" />
            </div>

            <div class="flex w-full pb-4 mt-6 space-x-4">
                <x-button  wire:target="submitForm2">
                    @lang('app.save')
                </x-button>
                <x-button-cancel  wire:click="$dispatch('hideEditPackage')" wire:loading.attr="disabled">@lang('app.cancel')</x-button-cancel>
            </div>
        </form>
    @endif
</div>
