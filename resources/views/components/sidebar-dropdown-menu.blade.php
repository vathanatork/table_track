<li>
    <button type="button"
        @class(['flex items-center w-full p-2 text-base transition duration-75 rounded-xl group hover:bg-gray-200 dark:text-gray-200 dark:hover:bg-gray-700', 'hover:text-gray-800 text-white font-bold bg-gray-700' => $active])
        aria-controls="dropdown-{{ \Str::slug($name) }}" data-collapse-toggle="dropdown-{{ \Str::slug($name) }}">
        {!! $icon !!}
        <span class="flex-1 ltr:ml-3 rtl:mr-3 text-left whitespace-nowrap" sidebar-toggle-item>{{ $name }}</span>
        <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                clip-rule="evenodd"></path>
        </svg>
    </button>
    <ul id="dropdown-{{ \Str::slug($name) }}" @class(['py-2 space-y-2', 'hidden' => !$active])>
        {{ $slot }}
    </ul>
</li>