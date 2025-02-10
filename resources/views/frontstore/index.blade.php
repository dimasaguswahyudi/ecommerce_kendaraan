@extends('layouts.frontstore.app')

@section('content')
<div class="container mx-auto px-3">
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
@endsection