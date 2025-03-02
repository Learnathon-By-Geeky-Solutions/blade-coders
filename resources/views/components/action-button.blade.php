@props(['color' => 'gray'])

<button {{ $attributes->merge(['class' => 'inline-flex h-6 w-6 items-center justify-center rounded bg-'.$color.'-200 text-center text-'.$color.'-600 hover:bg-'.$color.'-300']) }}>
    {{ $slot }}
</button>
