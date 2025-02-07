<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-wide btn-primary text-white'])
    }}>
    {{ $slot }}
</button>