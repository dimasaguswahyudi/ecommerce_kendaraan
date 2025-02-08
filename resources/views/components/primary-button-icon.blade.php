<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-primary rounded-full hover:bg-primary-600
  text-white
  btn-circle'])
  }}>
  {{ $slot }}
</button>