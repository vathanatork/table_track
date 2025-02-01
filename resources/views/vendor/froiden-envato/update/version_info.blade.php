
@php($envatoUpdateCompanySetting = \Froiden\Envato\Functions\EnvatoUpdate::companySetting())

<div class="flex flex-col">

    <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
        <thead class="bg-gray-100 dark:bg-gray-700">
            <tr>
                <th colspan="2" class="p-2 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">@lang('modules.update.systemDetails')</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700" wire:key='customer-list-{{ microtime() }}'>
            <tr>
                <td class="p-2 text-base text-gray-900 whitespace-nowrap dark:text-white">App Version</td>
                <td class="p-2 text-base text-gray-900 whitespace-nowrap dark:text-white">{{ $updateVersionInfo['appVersion'] }}
                    @if(!isset($updateVersionInfo['lastVersion']))
                        <i class="fa fa-check-circle text-success"></i>
                    @endif
                </td>
            </tr>

            @if(!app()->environment(['codecanyon','demo']))
                <tr>
                    <td class="p-2 text-base text-gray-900 whitespace-nowrap dark:text-white">App Environment</td>
                    <td class="p-2 text-base text-gray-900 whitespace-nowrap dark:text-white">{{ app()->environment() }}
                        @if(!isset($updateVersionInfo['lastVersion']))
                            <i class="fa fa-warning text-danger" title="Change the environment back to <b>codecanyon</b>"
                               data-toggle="tooltip" data-html="true"></i>
                        @endif
                    </td>
                </tr>
            @endif

            <tr>
                <td class="p-2 text-base text-gray-900 whitespace-nowrap dark:text-white">Laravel Version</td>
                <td class="p-2 text-base text-gray-900 whitespace-nowrap dark:text-white">{{ $updateVersionInfo['laravelVersion'] }}</td>
            </tr>

            <tr>
                <td class="p-2 text-base text-gray-900 whitespace-nowrap dark:text-white">PHP Version</td>
                <td class="p-2 text-base text-gray-900 whitespace-nowrap dark:text-white">
                    {{ phpversion() }}
                    @if (version_compare(PHP_VERSION, '8.2.0') >= 0)
                        <i class="fa fa-check-circle text-success"></i>
                    @else
                        <i data-toggle="tooltip" data-original-title="@lang('messages.phpUpdateRequired')" class="fa fa-warning text-danger"></i>
                    @endif
                </td>
            </tr>

            @if(!is_null($mysql_version))
                <tr>
                    <td class="p-2 text-base text-gray-900 whitespace-nowrap dark:text-white">{{ $databaseType }}</td>
                    <td class="p-2 text-base text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $mysql_version}}
                    </td>
                </tr>
            @endif
        </tbody>
    </table>

    @if(!is_null($envatoUpdateCompanySetting->purchase_code))
    <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600 mt-5">
        <thead class="bg-gray-100 dark:bg-gray-700">
            <th class="p-2 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400" width="25%">License Details</th>
        <th></th>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700" wire:key='customer-list-{{ microtime() }}'>
            <tr>
                <td class="p-2 text-base text-gray-900 whitespace-nowrap dark:text-white">Envato Purchase code</td>
                <td class="p-2 text-base text-gray-900 whitespace-nowrap dark:text-white flex items-center gap-1">
                    <span class="purchase-code blur-sm transition duration-300">{{$envatoUpdateCompanySetting->purchase_code}} </span>
                    <span class="show-hide-purchase-code" data-tooltip-target="purchase-tooltip-toggle" data-toggle="tooltip"
                          data-original-title="{{__('messages.showHidePurchaseCode')}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="icon hidden far fa-eye fa-fw cursor-pointer" viewBox="0 0 16 16">
  <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
  <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
</svg>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="icon  far fa-eye-slash fa-fw cursor-pointer" viewBox="0 0 16 16">
  <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7 7 0 0 0-2.79.588l.77.771A6 6 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755q-.247.248-.517.486z"/>
  <path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829"/>
  <path d="M3.35 5.47q-.27.24-.518.487A13 13 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7 7 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12z"/>
</svg>
                    </span>
                    <div id="purchase-tooltip-toggle" role="tooltip"
                         class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip">
                        Show and hide purchase code
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                    <a class="underline underline-offset-1 ml-4 text-skin-base" href="{{route('verify-purchase')}}">Change Purchase Code</a>
                </td>
            </tr>
            @if(!is_null($envatoUpdateCompanySetting?->purchased_on))
                <tr>
                    <td class="p-2 text-base text-gray-900 whitespace-nowrap dark:text-white">Purchased On</td>
                    <td class="p-2 text-base text-gray-900 whitespace-nowrap dark:text-white">
                        <span>{{\Carbon\Carbon::parse($envatoUpdateCompanySetting->purchased_on)->translatedFormat('D d M, Y')}} <small class="text-[12px] text-gray-500"> ({{\Carbon\Carbon::parse($envatoUpdateCompanySetting->purchased_on)->diffForHumans()}})</small></span>
                    </td>
                </tr>
            @endif
            @if(!is_null($envatoUpdateCompanySetting?->supported_until))
                <tr>
                    <td class="p-2 text-base text-gray-900 whitespace-nowrap dark:text-white">Support Expire</td>
                    <td class="p-2 text-base text-gray-900 whitespace-nowrap dark:text-white">
                        <span>{{\Carbon\Carbon::parse($envatoUpdateCompanySetting->supported_until)->translatedFormat('D d M, Y')}} <small class="text-[12px] text-gray-500"> ({{\Carbon\Carbon::parse($envatoUpdateCompanySetting->supported_until)->diffForHumans()}})</small>
                            @if(\Carbon\Carbon::parse($envatoUpdateCompanySetting->supported_until)->lessThan(now()))
                            <span class="text-red-500">Expired</span>
                            @endif
                        </span>
                    </td>
                </tr>
            @endif
            @if(!is_null($envatoUpdateCompanySetting->license_type))
                <tr>
                    <td class="p-2 text-base text-gray-900 whitespace-nowrap dark:text-white">License Type</td>
                    <td class="p-2 text-base text-gray-900 whitespace-nowrap dark:text-white">
                        <span>{{$envatoUpdateCompanySetting->license_type}}
                            @if(str_contains($envatoUpdateCompanySetting->license_type, 'Regular'))
                                <a href="{{'https://codecanyon.net/checkout/from_item/' . config('froiden_envato.envato_item_id') . '?license=extended'}}"
                                   class="underline underline-offset-1 ml-2 text-skin-base"
                                   target="_blank">Upgrade now </a>


                            @endif
                        </span>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>

        <script>


            document.body.addEventListener('click', function (event) {
                if (event.target.closest('.show-hide-purchase-code')) {

                    const button = event.target.closest('.show-hide-purchase-code');
                    const buttonEyeSlash = button.querySelector('.fa-eye-slash');
                    const icon = button.querySelector('.fa-eye');
                    const siblingSpan = button.previousElementSibling;
                    siblingSpan.classList.toggle('blur-sm');

                    buttonEyeSlash.classList.toggle('hidden');
                    icon.classList.toggle('hidden');
                }
            });
        </script>
    @endif
</div>

