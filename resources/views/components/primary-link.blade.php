<a
    {{ $attributes->merge(['type' => 'submit', 'class' => 'btn bg-orange-600 text-white border-orange-600 hover:bg-orange-800 hover:border-orange-800 active:bg-orange-800 active:border-orange-800 focus:outline-none focus:ring-4 focus:ring-orange-300']) }}>
    {{ $slot }}
</a>
