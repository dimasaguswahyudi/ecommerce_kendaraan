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
  <template x-for="(discount, index) in discounts" :key="index">
    <div class="card mb-4 background-yellow">
      <div class="card-body">
        <div class="label-section flex items-center max-w-fit min-w-fit mb-8">
          <div class="triangle mt-3 mb-0 mx-3 bg-primary-500 relative pl-9 pr-5 h-8 -skew-x-[30deg]">
            <div class="label-content flex items-center skew-x-[30deg]">
              <div class="label-icon p-2 rounded-full max-w-fit bg-white absolute -left-14 -top-[0.65em] 
                          border-2 border-gray-400 ring-primary">
                <figure>
                  <img :src="discount[0].category.image 
                  ? 'storage/' + discount[0].category.image 
                  : '{{ asset('assets/images/NoImagePersegi.png') }}'" class="w-8 h-8" alt="Discount Image">

                </figure>
              </div>
              <div class="label-title text-secondary-500 font-bold tracking-wider ml-2 mt-1" x-text="index">
              </div>
            </div>
          </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-9 gap-4">
          <template x-for="(items, index2) in discount" :key="index2">
            <div
              class="card bg-white border hover:bg-secondary-300 hover:font-bold hover:shadow-lg transition duration-300 cursor-pointer">
              <a href="javascript:void(0);" @click="applyFilter(items.id, '')"
                :class="{ 'bg-secondary-300 rounded-xl shadow-lg': selectedDiscount === items.id  }">

                <figure class="px-6 pt-6">
                  <img :src="items.image 
                  ? 'storage/' + items.image 
                  : '{{ asset('assets/images/NoImagePersegi.png') }}'" class="w-8 h-8" alt="Category Image">

                </figure>
                <div class="card-body py-3 px-6 items-center">
                  <div class="card-title text-sm hover:font-bold transition duration-300" x-text="items.name"></div>
                </div>
            </div>
          </template>
        </div>
      </div>
    </div>
  </template>

  {{-- product --}}
  <template x-for="(product, index) in products" :key="index">
    <div class="card mb-4" :class="product.length % 2 == 0 ? 'background-green' : 'background-yellow'">
      <div class="card-body">
        <div class="label-section flex items-center max-w-fit min-w-fit mb-8">
          <div class="triangle mt-3 mb-0 mx-3 bg-primary-500 relative pl-9 pr-5 h-8 -skew-x-[30deg]">
            <div class="label-content flex items-center skew-x-[30deg]">
              <div class="label-icon p-2 rounded-full max-w-fit bg-white absolute -left-14 -top-[0.65em] 
                          border-2 border-gray-400 ring-primary">
                <figure>
                  <img :src="product[0].category.image 
                    ? 'storage/' + product[0].category.image 
                    : '{{ asset('assets/images/NoImagePersegi.png') }}'" class="w-8 h-8" alt="Category Image">

                </figure>
              </div>
              <div class="label-title text-secondary-500 font-bold tracking-wider ml-2 mt-1" x-text="index">
              </div>
            </div>
          </div>
        </div>

        <div class="grid grid-cols-3 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-4 gap-4">
          <template x-for="(items, index2) in product" :key="index2">
            <div
              class="card bg-white border hover:bg-secondary-300 hover:shadow-lg transition duration-300 cursor-pointer">
              <figure class="px-6 pt-6">
                <img :src="items.image 
                ? 'storage/' + items.image 
                : '{{ asset('assets/images/NoImagePersegi.png') }}'" class="rounded-xl h-40 w-full object-cover"
                  alt="Category Image">

              </figure>
              <div class="card-body py-3 px-6 flex flex-col">
                <div class="card-title hover:font-bold transition duration-300" x-text="items.name"></div>
                <div class="flex justify-between items-center mt-auto w-full">
                  <label class="text-red-400 text-xl">
                    Rp. <span
                      x-text="formatRupiah(items.price - (items.price * (items.discount?.disc_percent || 0) / 100))"></span>
                  </label>
                  <div class="mb-auto">
                    <div class="flex gap-2">
                      <s class="text-xs text-gray-500" x-text="'Rp. ' + formatRupiah(items.price)"></s>
                      <small x-text="items.discount?.disc_percent ? items.discount.disc_percent + '%' : ''"></small>
                    </div>
                  </div>
                </div>
                <p x-text="limitText(items.description, 50)"></p>
                <div class="flex justify-between items-center mt-auto w-full">
                  <small class="text-gray-500" x-text="'Stock ' + items.stock + ' pcs'"></small>
                  <div class="ml-auto">
                    <button class="btn bg-primary-500 :hover:bg-primary-600 rounded-full btn-sm tooltip-bottom"
                      @click="addToCart(items.id, items.name, items.price, items.discount?.disc_percent || 0); setLabelCarts(); showToast('success', 'Produk Ditambahkan ke-chart')">
                      <img src="{{ asset('assets/images/icons/cart.png') }}" alt="icon-chart" class="h-5">
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </template>
        </div>
      </div>
    </div>
  </template>
</div>
@endsection

@push('scripts')
<script>

</script>
@endpush