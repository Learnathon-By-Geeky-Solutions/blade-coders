@props(['value'])

<label {{ $attributes->merge(['class' => 'inline-block font-semibold text-gray-800 mb-2']) }}>
    {{ $value ?? $slot }}
</label>
