@props(['disabled' => false, 'checked' => false])

<input type="checkbox" @disabled($disabled) @checked($checked)
    {{ $attributes->merge(['class' => 'relative h-5 w-[2.3rem] cursor-pointer rounded-full border-transparent bg-gray-200 p-px text-transparent transition-colors duration-200 ease-in-out before:inline-block before:h-4 before:w-4 before:translate-x-0 before:transform before:rounded-full before:bg-white before:shadow before:ring-0 before:transition before:duration-200 before:ease-in-out checked:border-orange-600 checked:bg-none checked:text-orange-600 checked:before:translate-x-full checked:before:bg-orange-50 focus:ring-orange-600 focus:checked:border-orange-600 disabled:pointer-events-none disabled:opacity-50']) }} />
