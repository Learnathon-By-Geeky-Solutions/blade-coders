@props(['title', 'heading', 'footer'])

<div class="card h-full shadow">
    @isset($title)
        <div class="flex items-center justify-between border-b border-gray-300 px-5 py-4">
            <h4>{{ $title }}</h4>
            @isset($heading)
                <div class="dropdown leading-4">
                    {{ $heading }}
                </div>
            @endisset
        </div>
    @endisset

    {{ $slot }}

    @isset($footer)
        <div class="flex items-center justify-between border-t border-gray-300 px-5 py-4">
            {{ $footer }}
        </div>
    @endisset
</div>
