<div class="navbar bg-primary-500 lg:px-12 py-4 sticky top-0 z-[999]" x-data="{ isLogin: false }">
  <div class="flex-none w-[18%]">
    <a href="{{ url('/') }}" class="text-white font-bold flex">
      <img src="{{ asset('assets/images/logo/LogoBp.jpg') }}" alt="Logo" class="h-16">
    </a>
  </div>
  <div class="flex-1">
    <div class="relative w-full max-w-md sm:max-w-lg lg:max-w-2xl">
      <input type="text" placeholder="Cari Produk" class="input h-10 input-bordered w-full pl-10">
      <i class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 fa-solid fa-magnifying-glass"></i>
    </div>
  </div>
  <div class="flex-none">
    <div class="flex items-center gap-4">
      <button class="btn bg-[#006547] text-white font-normal px-9">SUB - Surabaya</button>
      <button class="text-white">
        <img src="{{ asset('assets/images/icons/cart.png') }}" class="h-7" alt="Keranjang">
      </button>
      <button class="text-white">
        <img src="{{ asset('assets/images/icons/notifikasi.png') }}" class="h-7" alt="Notifikasi">
      </button>
      <button class="btn bg-secondary-500 text-primary-500 px-9">Login</button>
    </div>
  </div>
</div>