<div class="w-full py-6 dark:bg-gray-800">
    <div class="bg-white dark:bg-gray-700 shadow-md border dark:border-gray-600 rounded-lg">
        <!-- Header Section -->
        <div class="border-b border-gray-200 dark:border-gray-600 px-6 py-4 flex items-center justify-between">
            <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-200 flex items-center">
                <svg class="h-6 w-6 mr-2 text-skin-base" width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 13h16v7a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2zM2 9h20v4H2zm10-4v17m0-16.5A3.5 3.5 0 1 0 8.5 9m7 0A3.5 3.5 0 1 0 12 5.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                @lang('modules.billing.planDetails')
            </h4>
        </div>

        <div class="p-6 space-y-6">
            <!-- Current Plan Name -->
            <div>
                <h5 class="text-gray-600 dark:text-gray-400 text-sm font-medium">@lang('modules.billing.currentPlan')</h5>
                <h3 class="text-xl font-bold text-skin-base mt-2">{{ $currentPackageName ?? __('modules.billing.noPlanAssigned') }}</h3>
            </div>

            <!-- Current Plan Type -->
            <div>
                <h5 class="text-gray-600 dark:text-gray-400 text-sm font-medium">@lang('modules.billing.currentPlanType')</h5>
                <h3 class="text-xl font-bold text-skin-base mt-2">{{ $currentPackageType ?? __('modules.billing.noPlanAssigned') }}</h3>
            </div>

            {{-- <!-- License Expire On (Work In Progress) -->
            <div>
                <h5 class="text-gray-600 dark:text-gray-400 text-sm font-medium">@lang('modules.billing.licenseExpireOn')</h5>
                <h3 class="text-lg text-skin-base mt-2">
                    {{ $licenseExpireOn  ?? __('modules.billing.noPlanAssigned') }}

                    @if($licenseExpireOn)
                        @php
                            // Calculate the number of days left
                            $daysLeft = abs(now()->diffInDays($licenseExpireOn, false));

                            // Ensure days left is not negative (0 if expired or today)
                            $daysLeft = max($daysLeft, 0);

                            // Generate message based on the days left
                            $message = $daysLeft > 0
                                ? $daysLeft . ' ' . __('modules.billing.daysLeft')
                                : __('modules.billing.expired');
                        @endphp
                        <span>({{ $message }})</span>
                    @endif
                </h3>
            </div> --}}


            <!-- Upgrade Button -->
            <div>
                <a href="{{ route('pricing.plan') }}" wire:navigate >
                    <x-button class="inline-flex items-center shadow-md hover:origin-center group">
                        <svg class="w-5 h-5 text-current group-hover:scale-110 duration-500" width="24" height="24" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="currentColor"><path d="M7.657 6.247c.11-.33.576-.33.686 0l.645 1.937a2.89 2.89 0 0 0 1.829 1.828l1.936.645c.33.11.33.576 0 .686l-1.937.645a2.89 2.89 0 0 0-1.828 1.829l-.645 1.936a.361.361 0 0 1-.686 0l-.645-1.937a2.89 2.89 0 0 0-1.828-1.828l-1.937-.645a.361.361 0 0 1 0-.686l1.937-.645a2.89 2.89 0 0 0 1.828-1.828zM3.794 1.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387A1.73 1.73 0 0 0 4.593 5.69l-.387 1.162a.217.217 0 0 1-.412 0L3.407 5.69A1.73 1.73 0 0 0 2.31 4.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387A1.73 1.73 0 0 0 3.407 2.31zM10.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.16 1.16 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.16 1.16 0 0 0-.732-.732L9.1 2.137a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732z"/></svg>
                        @lang('modules.settings.upgradeLicense')
                    </x-button>
                </a>
            </div>
        </div>
    </div>
</div>
