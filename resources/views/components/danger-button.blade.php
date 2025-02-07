<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-error hover:bg-error-600 text-white']) }}>
    {{ $slot }}
</button>