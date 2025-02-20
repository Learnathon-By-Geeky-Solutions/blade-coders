@props(['href', 'active', 'icon'])

@php
    $classes = $active ?? false ? 'nav-link active' : 'nav-link';
@endphp

<li class="nav-item">
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @isset($icon)
            <i class="mr-2 h-4 w-4" data-feather="{{ $icon }}"></i>
        @endisset

        {{ $slot }}
    </a>
</li>
