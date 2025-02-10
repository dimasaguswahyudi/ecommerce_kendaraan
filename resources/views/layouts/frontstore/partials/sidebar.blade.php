<div x-show="sidebar">
  <aside x-show="show"
    class="hidden md:w-[18%] min-h-screen bg-[#ececec] text-primary px-4 py-2 md:flex flex-col fixed top-15 left-0 h-full">
    <div>
      <h1 class="font-bold text-xl px-5 mt-6 mb-0 text-primary-500">Pilih Kategori Barang</h1>
      <div class="divider"></div>
    </div>
    <nav class="flex-1 h-full pb-24 overflow-auto">
      <ul class="menu">
        @forelse ($categories as $category)
        <li class="mb-6">
          <a href="{{ route('frontstore.category', $category->slug) }}"
            class=" text-primary-600 font-semibold text-[16px] block px-4 py-2 transition-all duration-300 ease-in-out 
      opacity-80 hover:opacity-100 hover:translate-x-1
      {{ request()->slug == $category->slug ? 'active text-[18px] bg-primary-500 text-white rounded-lg' : 'hover:bg-neutral-100 hover:font-bold hover:text-[18px]' }}">
            <span>{{ $category->name }}</span>
          </a>
        </li>
        @empty
        <li>
          <h5>Kategori Tidak Tersedia</h5>
        </li>
        @endforelse
      </ul>
    </nav>
  </aside>
</div>