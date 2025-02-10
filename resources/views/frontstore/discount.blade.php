@forelse ($categories as $category)
<li class="mb-6">
  <a href="javascript:void(0);"
    @click="selectedCategory = '{{ $category->id }}'; filterByCategory('{{ $category->id }}')" :class="selectedCategory === '{{ $category->id }}' 
              ? 'active text-[18px] bg-primary-500 text-white rounded-lg' 
              : 'hover:bg-neutral-100 hover:font-bold hover:text-[18px]'"
    class="text-primary-600 font-semibold text-[16px] block px-4 py-2 transition-all duration-300 ease-in-out opacity-80 hover:opacity-100 hover:translate-x-1">
    <span>{{ $category->name }}</span>
  </a>
</li>
@empty
<li>
  <h5>Kategori Tidak Tersedia</h5>
</li>
@endforelse