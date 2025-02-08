@props(['disabled' => false])

<input type="file" @disabled($disabled) {{ $attributes->merge(['class' => 'file-input w-full']) }}>