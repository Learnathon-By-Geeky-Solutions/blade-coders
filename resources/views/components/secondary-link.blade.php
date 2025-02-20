<a {{ $attributes->merge(['type' => 'button', 'class' => 'btn gap-x-2 bg-teal-600 text-white border-teal-600 disabled:opacity-50 disabled:pointer-events-none hover:text-white hover:bg-teal-700 hover:border-teal-700 active:bg-teal-700 active:border-teal-700 focus:outline-none focus:ring-4 focus:ring-teal-300']) }}>
    {{ $slot }}
</a>
