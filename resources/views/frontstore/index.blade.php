@extends('layouts.frontstore.app')


@push('styles')
<style>
  .background-yellow {
    background-image: url('/assets/images/Byellow.png');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    height: 100%;
    border-radius: 20px
  }

  .background-green {
    background-image: url('/assets/images/Bgreen.png');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    height: 100%;
    border-radius: 20px
  }
</style>
@endpush

@section('content')
<div class="container mx-auto px-3">
  {{-- banner --}}
  <div class="mb-4">
    @if (count($banners) > 0)
    <div class="carousel w-full">
      @foreach ($banners as $banner)
      <div id="item{{ $banner->id }}" class="carousel-item w-full">
        <figure class="w-full bg-auto bg-center bg-no-repeat rounded-lg">
          <img src="{{ asset('storage/' . $banner->name) }}" class="w-full h-56 object-cover object-center rounded-lg"
            alt="{{ $banner->name }}">
        </figure>
      </div>
      @endforeach
    </div>
    <div class="flex w-full justify-center gap-2 py-2">
      @foreach ($banners as $key => $banner)
      <a href="#item{{ $banner->id }}" class="btn btn-xs">{{ $key+1 }}</a>
      @endforeach
    </div>
    @else
    <figure class="w-full bg-auto bg-center bg-no-repeat rounded-lg">
      <img src="{{ asset('assets/images/NoImage.png/') }}" class="w-full h-56 object-cover object-center rounded-lg"
        alt="No Image">
    </figure>
    @endif
  </div>

  {{-- discount --}}
  @if (count($discounts) > 0)
  @foreach ($discounts as $key => $discount)
  <div class="card mb-4 background-yellow">
    <div class="card-body">
      <div class="label-section flex items-center max-w-fit min-w-fit mb-8">
        <div class="triangle mt-3 mb-0 mx-3 bg-primary-500 relative pl-9 pr-5 h-8 -skew-x-[30deg]">
          <div class="label-content flex items-center skew-x-[30deg]">
            <div
              class="label-icon p-2 rounded-full max-w-fit bg-white absolute -left-14 -top-[0.65em] border-2 border-gray-400 ring-primary">
              <figure>
                @if ($discount[0]->Category->image == null)
                <img src="{{ asset('assets/images/NoImagePersegi.png') }}" class="w-8 h-8" alt="{{ $key }}" />
                @else
                <img src="{{ asset('storage/' . $discount[0]->Category->image) }}" class="w-8 h-8" alt="{{ $key }}" />
                @endif
              </figure>
            </div>
            <div class="label-title text-yellow-400 font-bold tracking-wider ml-2 mt-1">
              {{ $key }}
            </div>
          </div>
        </div>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-9 gap-4">
        @foreach ($discount as $item)
        <div class="card bg-white border hover:bg-secondary-300 hover:font-bold transition duration-300 cursor-pointer">
          <figure class="px-6 pt-6">
            @if ($item->image != null)
            <img src="{{ asset('storage/' . $item->image) }}" alt="Shoes" class="rounded-xl h-22" />
            @else
            <img src="{{ asset('assets/images/NoImagePersegi.png') }}" alt="Shoes" class="rounded-xl h-22" />
            @endif
          </figure>
          <div class="card-body py-3 px-6 items-center">
            <h5 class="card-title text-xs hover:font-bold transition duration-300">{{ $item->name }}</h5>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
  @endforeach
  @endif
</div>
@endsection