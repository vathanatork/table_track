<div class="flex flex-col bg-gray-50 lg:h-full w-full py-4 px-2 dark:bg-gray-900">
    <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700">
        <div class="flex items-center mb-4 sm:mb-0 justify-between">
            <form class="ltr:sm:pr-3 rtl:sm:pl-3" action="#" method="GET">
                <label for="products-search" class="sr-only">Search</label>
                <div class="relative w-48 mt-1 sm:w-64 xl:w-96">
                    <x-input class="block mt-1 w-full" type="text" placeholder="{{ __('placeholders.searchMenuItems') }}" wire:model.live.debounce.500ms="search"  />
                </div>
            </form>

                    
            <x-secondary-link href="{{ route('pos.index') }}" wire:navigate class="gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2z"/>
                    <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466"/>
                </svg>
                @lang('app.reset')
            </x-secondary-link>


        </div>

    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-6 2xl:grid-cols-8 gap-2 mt-6">
        <div wire:click="$set('filterCategories', null)" @class(['items-center font-medium shadow-sm cursor-pointer p-2 text-center rounded-md text-sm hover:text-gray-900 bg-white hover:bg-gray-200 w-full dark:bg-gray-800 dark:hover:bg-gray-700 dark:hover:text-white dark:text-neutral-200', ' border-2 border-gray-700' => (is_null($filterCategories))])>
            @lang('app.showAll')
        </div>
        @foreach($categoryList as $key => $value)
            <div wire:click="$set('filterCategories', {{ $value->id }})" @class(['items-center font-medium shadow-sm cursor-pointer p-2 text-center rounded-md text-sm hover:text-gray-900 bg-white hover:bg-gray-200 w-full dark:bg-gray-800 dark:hover:bg-gray-700 dark:hover:text-white dark:text-neutral-200', ' border-2 border-gray-700' => ($filterCategories == $value->id)])>
                {{ $value->category_name }}
            </div>
        @endforeach

    </div>

    <div class="mt-6">

        <ul class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-2 ">
            @forelse ($menuItems as $item)
            <li>
                <input type="checkbox" id="item-{{ $item->id }}" type="checkbox" value="{{ $item->id }}" wire:click='addCartItems({{ $item->id }}, {{ $item->variations_count }})' wire:key='item-input-{{ $item->id . microtime() }}' class="hidden peer">
                <label for="item-{{ $item->id }}" class="inline-flex items-center justify-between w-full text-gray-500 bg-white rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 peer-checked:border-skin-base peer-checked:border-2 hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                    <div class="w-full max-w-sm bg-white rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 p-2 space-y-2">
                        <div class="relative">

                            <img src="{{ asset('img/'.$item->type.'.svg')}}" class="h-4 absolute ltr:right-0 rtl:left-0 top-2" title="@lang('modules.menu.' . $item->type)" alt="" />
                            <div class="pt-2">
                                <h5 class="text-sm font-medium tracking-tight text-gray-900 dark:text-white">{{ $item->item_name }}</h5>
                            </div>
                        </div>
                        <div >
                            <div class="flex items-center justify-between">
                                @if ($item->variations_count == 0)
                                <span class="font-semibold text-gray-900 dark:text-white">{{ currency_format($item->price, restaurant()->currency_id) }}</span>
                                @else
                                <span class="text-xs text-gray-900 dark:text-white">@lang('modules.menu.showVariations')</span>
                                @endif

                                <img class="rounded-lg object-cover h-12 w-12" src="{{ $item->item_photo_url }}" alt="{{ $item->item_name }}" />

                            </div>
                        </div>
                    </div>
                </label>
            </li>
            @empty
                <li>@lang('messages.noItemAdded')</li>
            @endforelse
        </ul>

    </div>

</div>