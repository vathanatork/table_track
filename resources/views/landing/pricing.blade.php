<!-- Comparison Table -->
<div class="relative">
    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 mx-auto">
        <!-- Mobile View (Package Cards) -->
        <div class="lg:hidden space-y-4">
            @foreach($packages as $package)
            <div class="bg-white border border-gray-200 rounded-xl p-6 dark:bg-neutral-900 dark:border-neutral-800">
                <div class="mb-4">
                    <h3 class="font-semibold text-lg text-gray-800 dark:text-neutral-200">
                        {{ $package->package_name }}
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-neutral-500 mt-1">
                        <span class="font-bold text-skin-base text-lg">
                            {{ $package->package_type == \App\Enums\PackageType::LIFETIME ? $package->currency->currency_symbol . $package->price : $package->currency->currency_symbol . $package->monthly_price }}
                  </span>
                        {{ $package->package_type == \App\Enums\PackageType::LIFETIME ? __('modules.package.payOnce') : __('modules.package.payMonthly') }}
                  </p>
                </div>

                <a class="w-full py-2 px-3 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-gray-50 dark:bg-transparent dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800 mb-4" href="#">
                    @lang('landing.getStarted')
                </a>

                <!-- Module List -->
                <div class="space-y-3">
                    @foreach($modules as $module)
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-800 dark:text-neutral-200">{{ $module->name }}</span>
                        @if($package->hasModule($module->id))
                        <svg class="shrink-0 size-5 text-skin-base" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        @else
                        <svg class="shrink-0 size-5 text-gray-400 dark:text-neutral-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/></svg>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>

        <!-- Desktop View (Comparison Table) -->
        <div class="hidden lg:block overflow-x-auto">
            <!-- Header -->
            <div class="flex gap-6">
                <div class="lg:pb-1.5 lg:py-3 min-w-48 sticky left-0 bg-white dark:bg-gray-900 z-10">
              <!-- Header -->
                    <div class="h-full"></div>
                    <!-- End Header -->
                </div>
  
                @foreach($packages as $package)
                <div class="min-w-48">
              <!-- Header -->
              <div class="h-full p-4 flex flex-col justify-between bg-white border border-gray-200 rounded-xl dark:bg-neutral-900 dark:border-neutral-800">
                        <div class="flex flex-col gap-2">
                            <span class="font-semibold text-base text-gray-800 dark:text-neutral-200">
                                {{ $package->package_name }}
                  </span>
                  <p class="text-xs text-gray-500 dark:text-neutral-500">
                                <span class="font-bold text-skin-base text-lg">
                                    {{ $package->package_type == \App\Enums\PackageType::LIFETIME ? global_currency_format($package->price, $package->currency_id) : global_currency_format($package->monthly_price, $package->currency_id) }}
                                </span>
                                {{ $package->package_type == \App\Enums\PackageType::LIFETIME ? __('modules.package.payOnce') : __('modules.package.payMonthly') }}
                  </p>
                </div>
                <div class="mt-2">
                  <a class="w-full py-2 px-3 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-gray-50 dark:bg-transparent dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800" href="#">
                                @lang('landing.getStarted')
                  </a>
                </div>
              </div>
                </div>
                @endforeach
            </div>

            <!-- Features Section -->
            <div class="space-y-4 mt-6">
                @foreach($modules as $module)
                <ul class="flex gap-6 relative">
                    <li class="lg:pb-1.5 lg:py-3 min-w-48 sticky left-0 bg-white dark:bg-gray-900 z-10">
              <span class="text-sm text-gray-800 dark:text-neutral-200">
                            {{ $module->name }}
              </span>
            </li>
  
                    @foreach($packages as $package)
                    <li class="py-1.5 lg:py-3 px-4 lg:px-0 lg:text-center bg-gray-50 dark:bg-neutral-800 min-w-48">
              <div class="grid grid-cols-6 lg:block">
                            @if($package->hasModule($module->id))
                            <svg class="shrink-0 lg:mx-auto size-5 text-skin-base" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            @else
                <svg class="shrink-0 lg:mx-auto size-5 text-gray-400 dark:text-neutral-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/></svg>
                            @endif
              </div>
            </li>
                    @endforeach
          </ul>
                @endforeach
          </div>
        </div>
    </div>
  </div>
  <!-- End Comparison Table -->