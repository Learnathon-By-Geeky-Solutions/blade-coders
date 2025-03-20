@props(['color' => 'gray', 'icon' => null])

<a
    {{ $attributes->merge(['class' => 'inline-flex h-6 w-6 items-center justify-center rounded bg-' . $color . '-200 text-center text-' . $color . '-600 hover:bg-' . $color . '-300']) }}>
    @isset($icon)
        <i class="size-4" data-feather="{{ $icon }}"></i>
    @endif
    {{ $slot }}
</a>
