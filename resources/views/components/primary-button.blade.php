<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-primary hover:bg-primary-600 text-white'])
    }}>
    {{ $slot }}
</button>