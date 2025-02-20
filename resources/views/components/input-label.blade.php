@props(['value'])

<label {{ $attributes->merge(['class' => 'inline-block mb-2']) }}>
    {{ $value ?? $slot }}
</label>
