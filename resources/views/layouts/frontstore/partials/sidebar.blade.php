<div>
  <aside
    class="hidden md:w-[18%] min-h-screen bg-[#ececec] text-primary px-4 py-2 md:flex flex-col fixed top-15 left-0 h-full">
    <div>
      <h1 class="font-bold text-xl px-5 mt-6 mb-0 text-primary-500">Pilih Kategori Barang</h1>
      <div class="divider"></div>
    </div>
    <nav class="flex-1 h-full pb-24 overflow-auto">
      <ul class="menu">
        <template x-for="(category, index) in categories" :key="index">
          <li class="mb-6">
            <a href="javascript:void(0);" @click="applyFilter('', category.id)"
              class="block text-primary-500 text-[16px] font-semibold px-4 py-2 rounded transition-all duration-500 ease-in-out"
              :class="{ 
                'hover:bg-neutral-100 hover:font-bold hover:text-[18px]': selectedCategory !== category.id 
              }">
              <span x-text="category.name"></span>
            </a>
          </li>
        </template>
      </ul>
    </nav>
  </aside>
</div>