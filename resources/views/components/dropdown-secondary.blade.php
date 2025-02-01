@props([
'align' => 'left',
'width' => '48',
'contentClasses' => 'py-1 bg-white dark:bg-gray-700',
'dropdownClasses' => '',
'trigger' => 'Options',
'mainClass' => 'justify-baseline',
])

@php
$alignmentClasses = match($align) {
'left' => 'ltr:origin-top-left rtl:origin-top-right start-0',
'top' => 'origin-top',
'right' => 'ltr:origin-top-right rtl:origin-top-left end-0',
default => 'ltr:origin-top-left rtl:origin-top-right start-0',
};

$widthClass = $width === '48' ? 'w-48' : 'w-64';
@endphp

<div class="flex {{ $mainClass }}">
    <div x-data="{
        open: false,
        toggle() {
            this.open = !this.open;
            this.$refs.button.focus();
        },
        close(focusAfter) {
            if (!this.open) return;
            this.open = false;
            focusAfter && focusAfter.focus();
        }
        }" x-on:keydown.escape.prevent.stop="close($refs.button)"
         x-on:focusin.window="!$refs.panel.contains($event.target) && close()" x-id="['dropdown-button']"
         class="relative">

        <!-- Button -->
        <button x-ref="button" x-on:click="toggle()" :aria-expanded="open.toString()" :aria-controls="$id('dropdown-button')" type="button"
             class="inline-flex items-center px-3 py-2 border dark:border-gray-400 text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 dark:hover:text-gray-400 focus:outline-none transition ease-in-out duration-150">
            <span>{{ $trigger }}</span>
            <!-- Icon -->
            <svg class="w-2.5 h-2.5 ms-1" height="24" width="24" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                 fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                     d="m1 1 4 4 4-4" />
            </svg>
        </button>

        <!-- Dropdown Panel -->
        <div x-ref="panel" x-show="open" x-transition.origin.top.left x-on:click.outside="close($refs.button)"
             :id="$id('dropdown-button')" x-cloak class="absolute mt-2 rounded-lg shadow-sm
                {{ $widthClass }} {{ $alignmentClasses }} {{ $dropdownClasses }} z-50 origin-top-left
                bg-white border border-gray-200 p-1.5 dark:bg-gray-800 dark:border-gray-700">

            <!-- Dropdown Items (Dynamic Content) -->
            <div class="{{ $contentClasses }}">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
