<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center p-1 p-border border-transparent rounded-md font-hair text-sm text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 rounded-lg']) }}>
    {{ $slot }}
</button>
