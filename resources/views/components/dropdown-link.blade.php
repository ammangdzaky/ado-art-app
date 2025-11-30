<a {{ $attributes->merge(['class' => 'block w-full px-4 py-2.5 text-start text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-[#252525] hover:text-indigo-600 dark:hover:text-white focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out flex items-center gap-2']) }}>
    {{ $slot }}
</a>