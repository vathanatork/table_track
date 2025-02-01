<div class="lg:w-5/12 flex flex-col bg-white border-l dark:border-gray-700 min-h-screen h-auto pr-4 px-2 py-4 dark:bg-gray-800">
    <div class="flex-grow">
        <div class="flex justify-between mb-2 items-center">
            <div class="font-medium py-2 inline-flex items-center gap-1 dark:text-neutral-200">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-receipt w-6 h-6" viewBox="0 0 16 16">
                    <path d="M1.92.506a.5.5 0 0 1 .434.14L3 1.293l.646-.647a.5.5 0 0 1 .708 0L5 1.293l.646-.647a.5.5 0 0 1 .708 0L7 1.293l.646-.647a.5.5 0 0 1 .708 0L9 1.293l.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .801.13l.5 1A.5.5 0 0 1 15 2v12a.5.5 0 0 1-.053.224l-.5 1a.5.5 0 0 1-.8.13L13 14.707l-.646.647a.5.5 0 0 1-.708 0L11 14.707l-.646.647a.5.5 0 0 1-.708 0L9 14.707l-.646.647a.5.5 0 0 1-.708 0L7 14.707l-.646.647a.5.5 0 0 1-.708 0L5 14.707l-.646.647a.5.5 0 0 1-.708 0L3 14.707l-.646.647a.5.5 0 0 1-.801-.13l-.5-1A.5.5 0 0 1 1 14V2a.5.5 0 0 1 .053-.224l.5-1a.5.5 0 0 1 .367-.27m.217 1.338L2 2.118v11.764l.137.274.51-.51a.5.5 0 0 1 .707 0l.646.647.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.509.509.137-.274V2.118l-.137-.274-.51.51a.5.5 0 0 1-.707 0L12 1.707l-.646.647a.5.5 0 0 1-.708 0L10 1.707l-.646.647a.5.5 0 0 1-.708 0L8 1.707l-.646.647a.5.5 0 0 1-.708 0L6 1.707l-.646.647a.5.5 0 0 1-.708 0L4 1.707l-.646.647a.5.5 0 0 1-.708 0z"/>
                    <path d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5m8-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5"/>
                </svg>
                @lang('modules.order.orderNumber') #{{ $orderNumber }}
            </div>

            <div class="inline-flex items-center gap-2 dark:text-gray-300">
                @if (!is_null($tableNo))
                <svg  fill="currentColor" class="w-5 h-5 transition duration-75 group-hover:text-gray-900 dark:text-gray-200  dark:group-hover:text-white" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 44.999 44.999" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M42.558,23.378l2.406-10.92c0.18-0.816-0.336-1.624-1.152-1.803c-0.816-0.182-1.623,0.335-1.802,1.151l-2.145,9.733 h-9.647c-0.835,0-1.512,0.677-1.512,1.513c0,0.836,0.677,1.513,1.512,1.513h0.573l-3.258,7.713 c-0.325,0.771,0.034,1.657,0.805,1.982c0.19,0.081,0.392,0.12,0.588,0.12c0.59,0,1.15-0.348,1.394-0.925l2.974-7.038l4.717,0.001 l2.971,7.037c0.327,0.77,1.215,1.127,1.982,0.805c0.77-0.325,1.13-1.212,0.805-1.982l-3.257-7.713h0.573 C41.791,24.564,42.403,24.072,42.558,23.378z"></path> <path d="M14.208,24.564h0.573c0.835,0,1.512-0.677,1.512-1.513c0-0.836-0.677-1.513-1.512-1.513H5.134L2.99,11.806 C2.809,10.99,2,10.472,1.188,10.655c-0.815,0.179-1.332,0.987-1.152,1.803l2.406,10.92c0.153,0.693,0.767,1.187,1.477,1.187h0.573 L1.234,32.28c-0.325,0.77,0.035,1.655,0.805,1.98c0.768,0.324,1.656-0.036,1.982-0.805l2.971-7.037l4.717-0.001l2.972,7.038 c0.244,0.577,0.804,0.925,1.394,0.925c0.196,0,0.396-0.039,0.588-0.12c0.77-0.325,1.13-1.212,0.805-1.98L14.208,24.564z"></path> <path d="M24.862,31.353h-0.852V18.308h8.13c0.835,0,1.513-0.677,1.513-1.512s-0.678-1.513-1.513-1.513H12.856 c-0.835,0-1.513,0.678-1.513,1.513c0,0.834,0.678,1.512,1.513,1.512h8.13v13.045h-0.852c-0.835,0-1.512,0.679-1.512,1.514 s0.677,1.513,1.512,1.513h4.728c0.837,0,1.514-0.678,1.514-1.513S25.699,31.353,24.862,31.353z"></path> </g> </g> </g></svg>
                {{ $tableNo }}

                <x-secondary-button wire:click="$toggle('showTableModal')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear" viewBox="0 0 16 16">
                        <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492M5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0"/>
                        <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115z"/>
                    </svg>
                </x-secondary-button>
                @else
                <x-secondary-button wire:click="$toggle('showTableModal')">@lang('modules.order.setTable')</x-secondary-button>
                @endif
            </div>
        </div>
        <div class="flex justify-between mb-2 items-center gap-2">
            <div class="py-2 inline-flex items-center gap-1 text-sm dark:text-gray-300">
                @lang('modules.order.noOfPax') <x-input type="number" step='1' min='1' class="w-16 text-sm" wire:model='noOfPax' />
            </div>

            <div class="gap-2 inline-flex items-center">
                <x-select class="text-sm w-36 xl:w-fit" wire:model='selectWaiter'>
                    <option value="">@lang('modules.order.selectWaiter')</option>
                    @foreach ($users as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </x-select>
            </div>
        </div>

        @foreach ($kotList as $kot)
            <div class="flex justify-between font-medium text-xs text-gray-500 p-2 bg-gray-100 dark:bg-gray-700">
                <div>@lang('menu.kot') #{{ $kot->kot_number }}</div>

                <div>{{ $kot->created_at->timezone(timezone())->translatedFormat('d F, H:i A') }}</div>
            </div>

            <div class="flex flex-col rounded ">
                <table class=" flex-1  min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                    <thead>
                        <tr>
                            <th scope="col"
                                class="p-2 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                @lang('modules.menu.itemName')
                            </th>
                            <th scope="col"
                                class="p-2 text-xs font-medium   text-center text-gray-500 uppercase dark:text-gray-400">
                                @lang('modules.order.qty')
                            </th>
                            <th scope="col"
                                class="p-2 text-xs font-medium text-right text-gray-500 uppercase dark:text-gray-400">
                                @lang('modules.order.price')
                            </th>
                            <th scope="col"
                                class="p-2 text-xs font-medium text-right text-gray-500 uppercase dark:text-gray-400">
                                @lang('modules.order.amount')
                            </th>
                            @if (user_can('Delete Order'))
                            <th scope="col"
                                class="p-2 text-xs font-medium text-gray-500 uppercase dark:text-gray-400 text-right">
                                @lang('app.action')
                            </th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700" wire:key='menu-item-list-{{ microtime() }}'>

                        @forelse ($orderItemList as $key => $item)

                        @continue(!strpos($key, 'kot_' . $kot->id))

                        @php
                            $itemName = $item->item_name;
                            $itemVariation = (isset($orderItemVariation[$key]) ? $orderItemVariation[$key]->variation : '');
                            $itemPrice = (isset($orderItemVariation[$key]) ? $orderItemVariation[$key]->price : $item->price);
                        @endphp
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700" wire:key='menu-item-{{ $key . microtime() }}' wire:loading.class.delay='opacity-10'>
                            <td class="flex flex-col p-2 mr-12 lg:min-w-28">
                                <div class="text-xs text-gray-900 dark:text-white inline-flex items-center">
                                    {{ $itemName }}
                                </div>
                                <div class="text-xs text-gray-600 dark:text-white inline-flex items-center">
                                    {{  $itemVariation }}
                                </div>

                            </td>
                            <td class="p-2 text-base text-gray-900 whitespace-nowrap text-center">

                                <div class="relative flex items-center max-w-[8rem] mx-auto" wire:key='orderItemQty-{{ $key }}-counter'>
                                    <button type="button" wire:click="subQty('{{ $key }}')" class="bg-gray-50 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-s-md p-3 h-8">
                                        <svg class="w-2 h-2 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16"/>
                                        </svg>
                                    </button>

                                    <input type="text" wire:model='orderItemQty.{{ $key }}' class="min-w-10 bg-white border-x-0 border-gray-300 h-8 text-center text-gray-900 text-sm  block w-full py-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white " value="1" readonly  />

                                    <button type="button" wire:click="addQty('{{ $key }}')"  class="bg-gray-50 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-e-md p-3 h-8 ">
                                        <svg class="w-2 h-2 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                                        </svg>
                                    </button>
                                </div>

                            </td>

                            <td class="p-2 text-xs font-medium text-gray-700 whitespace-nowrap dark:text-white text-right">
                                {{ currency_format($itemPrice)}}
                            </td>
                            <td class="p-2 text-xs font-medium text-gray-900 whitespace-nowrap dark:text-white text-right">
                                {{ currency_format($orderItemQty[$key] * $itemPrice) }}
                            </td>
                            @if (user_can('Delete Order'))
                            <td class="p-2 whitespace-nowrap text-right">
                                <button class="rounded text-gray-700 border p-2" wire:click="deleteCartItems('{{ $key }}')">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </td>
                            @endif
                        </tr>
                        @empty
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                            <td class="p-2 space-x-6" colspan="5">
                                @lang('messages.noItemAdded')
                            </td>
                        </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        @endforeach

    </div>

    <div>
        <div class="h-auto p-4 mt-3 select-none text-center w-full bg-gray-50 rounded space-y-4 dark:bg-gray-700">
            <div class="flex justify-between text-gray-500 dark:text-neutral-400 text-sm">
                <div>
                    @lang('modules.order.totalItem')
                </div>
                <div>
                    {{ count($orderItemList) }}
                </div>
            </div>
            <div class="flex justify-between text-gray-500 dark:text-neutral-400 text-sm">
                <div>
                    @lang('modules.order.subTotal')
                </div>
                <div>
                    {{ currency_format($subTotal) }}
                </div>
            </div>
            @foreach ($taxes as $item)
            <div class="flex justify-between text-gray-500 dark:text-neutral-400 text-sm">
                <div>
                    {{ $item->tax_name }} ({{ $item->tax_percent }}%)
                </div>
                <div>
                    {{ currency_format(($item->tax_percent / 100) * $subTotal) }}
                </div>
            </div>
            @endforeach
            <div class="flex justify-between font-medium text-gray-900 dark:text-gray-100">
                <div>
                    @lang('modules.order.total')
                </div>
                <div>
                    {{ currency_format($total) }}
                </div>
            </div>
        </div>

        <div class="h-auto pb-4 pt-3 select-none text-center w-full">
            @if ($orderDetail->status == 'kot')
                <div class="grid grid-cols-2 gap-4">
                    <button class="rounded bg-skin-base text-white w-full p-2" wire:click="saveOrder('bill')">
                        @lang('modules.order.bill')
                    </button>

                    <button class="rounded bg-green-500 text-white w-full p-2" wire:click="saveOrder('bill', 'payment')">
                        @lang('modules.order.billAndPayment')
                    </button>
                    <button class="rounded bg-blue-500 text-white w-full p-2" wire:click="saveOrder('bill', 'print')">
                        @lang('modules.order.createBillAndPrintReceipt')
                    </button>

                    <a href="{{ route('pos.kot', ['id' => $orderDetail->id]) }}" class="rounded bg-white text-skin-base border border-skin-base w-full p-2">
                        @lang('modules.order.newKot')
                    </a>

                </div>
            @endif

            @if ($orderDetail->status == 'billed')
                <div class="flex gap-2">
                    <button class="rounded bg-skin-base text-white w-full p-2" wire:click="saveOrder('bill')">
                        @lang('modules.order.addPayment')
                    </button>
                </div>
            @endif

        </div>
    </div>
</div>
