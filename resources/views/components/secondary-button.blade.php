<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-black bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 transition-all duration-200 gap-2']) }}>
    {{ $slot }}
</button>
