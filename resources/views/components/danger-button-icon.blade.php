<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn rounded-full btn-sm btn-error hover:bg-error-600
    text-white']) }}>
    {{ $slot }}
</button>