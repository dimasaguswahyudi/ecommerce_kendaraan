@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'input input-md input-bordered w-full']) }}>