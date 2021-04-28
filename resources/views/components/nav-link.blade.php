@props(['active'])

@php
$classes = ($active ?? false)
            ? 'bg-indigo-700 text-white rounded-md py-2 px-3 text-sm font-medium transition duration-150 ease-in-out'
            : 'text-white hover:bg-indigo-500 hover:bg-opacity-75 rounded-md py-2 px-3 text-sm font-medium transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
