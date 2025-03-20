@props(['disabled' => false, 'value' => null])

<textarea
    @disabled($disabled)
    {{ $attributes->merge(['class' => 'border border-gray-300 text-gray-900 rounded focus:ring-indigo-600 focus:border-indigo-600 block w-full h-30 p-2 px-3 disabled:opacity-50 disabled:pointer-events-none']) }}>{{ $value }}</textarea>
