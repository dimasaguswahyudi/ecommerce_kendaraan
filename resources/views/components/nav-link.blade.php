@props(['active'])

@php
$classes = ($active ?? false)
? 'inline-flex items-center px-1 pt-1 border-b-2 border-secondary-400 text-sm font-medium leading-5 text-secondary-300
focus:outline-none focus:border-secondary-300 transition duration-150 ease-in-out'
: 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-white
hover:text-secondary-700 hover:border-gray-300 focus:outline-none focus:text-secondary-300 focus:border-secondary-300
transition
duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>