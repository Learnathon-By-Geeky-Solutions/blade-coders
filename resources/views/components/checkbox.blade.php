@props(['disabled' => false, 'checked' => 'false'])

<input type="checkbox" @disabled($disabled) @checked($checked) {{ $attributes->merge(['class' => 'h-4 w-4 rounded border-gray-300 bg-white text-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-600']) }} />
