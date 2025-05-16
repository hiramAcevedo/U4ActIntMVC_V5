<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-black bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900 transition-all duration-200 gap-2']) }}>
    {{ $slot }}
</button>
