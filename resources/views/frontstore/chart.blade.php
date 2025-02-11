@extends('layouts.frontstore.app')

@section('content')
<div class="container mx-auto px-3">
  <div class="w-full" x-data="cartData()">
    <div class="card card-compact bg-base-100 w-full shadow-md">
      <div class="card-body w-full">
        <div class="flex justify-between items-center">
          <h2 class="card-title">Your Cart</h2>
          <a href="{{ url('/') }}">
            <secondary-button class="btn btn-secondary text-primary-500 hover:btn-secondary-600 ml-auto">
              <span class="material-icons-outlined">keyboard_arrow_left</span> Back To Shopping
              </button>
            </secondary-button>
          </a>
        </div>
        <div class="divider"></div>
        <template>
        </template>
        <div class="card card-side bg-base-100 border mb-2">
          <figure>
            <img src="https://img.daisyui.com/images/stock/photo-1635805737707-575885ab0820.webp" alt="Movie" />
          </figure>
          <x-danger-button-icon> <span class="material-icons-outlined text-[14px]">delete</span> </x-danger-button-icon>
          <div class="card-body">
            <h2 class="card-title">New movie is released!</h2>
            <p>Click the button to watch on Jetflix app.</p>
          </div>
        </div>
        <div class="card-actions justify-end">
          <x-primary-button class="btn btn-primary">Buy Now</x-primary-button>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
  function cartData() {
    return{
      cart: getCarts()
    }
  }
</script>
@endpush