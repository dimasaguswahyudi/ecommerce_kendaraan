<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-secondary hover:bg-secondary-600
    text-white'])
    }}>
    {{ $slot }}
</button>