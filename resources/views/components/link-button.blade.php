@props([
    'state' => 'primary',
    'colors' => [
        'primary' => 'bg-indigo-400 text-white hover:bg-indigo-700',
        'danger' => 'bg-red-400 text-white hover:bg-red-700',
        'cancel' => 'bg-white text-gray-700 hover:bg-gray-50 border border-gray-300',
    ],
])
<a {{ $attributes->merge(['class' => "{$colors[$state]} inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150" ]) }}>
    {{ $slot }}
</a>
