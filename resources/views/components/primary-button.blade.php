<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn bg-indigo-600 text-white border-indigo-600 hover:bg-indigo-800 hover:border-indigo-800 active:bg-indigo-800 active:border-indigo-800 focus:outline-none focus:ring-4 focus:ring-indigo-300']) }}>
    {{ $slot }}
</button>
