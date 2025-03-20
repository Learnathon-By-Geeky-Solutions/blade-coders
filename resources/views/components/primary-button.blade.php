<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'btn inline-flex items-center justify-center gap-x-2 bg-orange-600 text-white border-orange-600 hover:bg-orange-800 hover:border-orange-800 active:bg-orange-800 active:border-orange-800 focus:outline-none focus:ring-4 focus:ring-orange-300']) }}>
    @isset($icon)
        <i class="size-4" data-feather="{{ $icon }}"></i>
    @endif
    {{ $slot }}
</button>
