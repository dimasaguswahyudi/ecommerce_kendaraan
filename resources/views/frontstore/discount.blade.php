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
          <div class="label-title text-secodary-500 font-bold text-secondary-500 tracking-wider ml-2 mt-1">
            {{ $key }}
          </div>
        </div>
      </div>
    </div>
    <div>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-9 gap-4">
        @foreach ($discount as $item)
        <div
          class="card bg-white border hover:bg-secondary-300 hover:font-bold hover:shadow-lg transition duration-300 cursor-pointer">
          <a href="javascript:void(0);" @click="applyFilter({{ $item->id }})"
            :class="{ 'bg-secondary-300 rounded-xl shadow-lg': selectedDiscount === {{ $item->id }} }">

            <figure class="px-6 pt-6">
              @if ($item->image != null)
              <img src="{{ asset('storage/' . $item->image) }}" alt="Shoes" class="rounded-xl h-16" />
              @else
              <img src="{{ asset('assets/images/NoImagePersegi.png') }}" alt="Shoes" class="rounded-xl h-16" />
              @endif
            </figure>

            <div class="card-body py-3 px-6 items-center">
              <h5 class="card-title text-sm hover:font-bold transition duration-300">{{ $item->name }}</h5>
            </div>
          </a>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
@endforeach
@endif