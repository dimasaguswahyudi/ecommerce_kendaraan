<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Product') }}
      </h2>
      <x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'form-product');$dispatch('reset-form');">
        <span class="material-icons-outlined text-[20px]">add</span> {{ __('Create New') }}
      </x-primary-button>
    </div>
  </x-slot>


  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="card bg-white p-5">
        <div class="card-body">
          <div class="overflow-x-auto">
            <table class="table table-xs w-full">
              <thead>
                <tr>
                  <th></th>
                  <th>Category</th>
                  <th>Name</th>
                  <th class="text-center">Image</th>
                  <th>Discount</th>
                  <th>Price</th>
                  <th>Stock</th>
                  <th>Description</th>
                  <th>Status Active</th>
                  <th>Created At</th>
                  <th>Updated At</th>
                  <th class="text-center">Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($products as $index => $product)
                <tr>
                  <td class="text-center">
                    {{ $loop->iteration + ($products->currentPage() - 1) * $products->perPage() }}
                  </td>
                  <td>{{ $product->Category->name }}</td>
                  <td>{{ $product->name }}</td>
                  <td class="text-center">
                    @if (!empty($product->image))
                    <div class="avatar">
                      <div class="w-16 rounded">
                        <img src="{{ asset('storage/' . $product->image) }}" />
                      </div>
                    </div>
                    @else
                    -
                    @endif
                  </td>
                  <td>{{ $product->Discount != null ? $product->Discount->disc_percent .'%' : '-' }}</td>
                  <td>
                    @if ($product->Discount != null)
                    <div class="lh-sm">
                      <s class="text-red-500 text-[10px]">
                        {{ formatRupiah($product->price) }}</s>
                      <label class="font-bold">{{ formatRupiah($product->price - ($product->price *
                        $product->Discount->disc_percent) /
                        100)
                        }}
                      </label>
                    </div>
                    @else
                    <label class="font-normal">
                      {{ formatRupiah($product->price) }}
                    </label>
                    @endif
                  </td>
                  <td>{{ $product->stock }}</td>
                  <td>{{ $product->description }}</td>
                  <td>{{ $product->is_active ? 'Active' : 'Inactive' }}</td>
                  <td>{{ $product->created_at->format('d/m/Y H:i') }}</td>
                  <td>{{ $product->updated_at->format('d/m/Y H:i') }}</td>
                  <td>
                    <div class="flex gap-2 justify-center">
                      <x-primary-button-icon x-data="" x-on:click.prevent="
                                        $dispatch('open-modal', 'form-product');
                                        $dispatch('reset-form')
                                        $dispatch('set-edit-data', {
                                            actionUrl: '{{ route('admin.product.update', $product->id) }}',
                                            category_id: '{{ $product->category_id }}',
                                            discount_id: '{{ $product->discount_id ?? '' }}',
                                            name: '{{ $product->name }}',
                                            slug: '{{ $product->slug }}',
                                            description: '{{ $product->description }}',
                                            price: '{{ $product->price }}',
                                            stock: '{{ $product->stock }}',
                                            is_active: '{{ $product->is_active == 1 ? 'true' : 'false' }}',
                                        });
                                    ">
                        <span class="material-icons-outlined text-[14px]">edit</span>
                      </x-primary-button-icon>
                      <x-danger-button-icon class="btn-circle" x-data="" x-on:click.prevent="
                                        $dispatch('open-modal', 'confirm-delete');
                                        $dispatch('set-delete-action', '{{ route('admin.product.destroy', $product->id) }}');
                                    ">
                        <span class="material-icons-outlined text-[14px]">delete</span>
                      </x-danger-button-icon>
                    </div>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="4" class="text-center text-slate-500">No Data Found.</td>
                </tr>
                @endforelse
              </tbody>
            </table>
            <div class="mt-4">
              {{ $products->links('pagination::tailwind') }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <x-modal name="form-product" maxWidth="xl" :show="$errors->isNotEmpty()" focusable>
    <div class="card">
      <div class="card-body">
        <div x-data="ProductForm" x-init="init()">
          <form method="post" :action="formAction" enctype="multipart/form-data">
            <h2 class="card-title" x-show="!isEdit">
              Add Product
            </h2>
            <h2 class="card-title" x-show="isEdit">
              Edit Product
            </h2>
            @csrf
            <template x-if="isEdit">
              @method('PUT')
            </template>

            <div class="grid grid-cols-2 gap-4">
              <!-- Kolom Kiri -->
              <div>
                <div class="mb-3">
                  <x-input-label for="category_id" value="{{ __('Category *') }}" />
                  <x-text-input id="category_id" name="category_id" type="hidden"
                    placeholder="{{ __('Select Category') }}" class="mt-1" x-model="category_id" />
                  <div class="relative w-full">
                    <x-text-input id="category_display" name="category_display" type="text" x-model="category"
                      x-on:input="searchCategory()" class="mt-1" />
                    <template x-if="category && filteredCategories.length > 0">
                      <div
                        class="absolute shadow-xl w-full min-h-48 max-h-48 bg-white z-10 border border-gray-300 mt-1 rounded overflow-y-auto">
                        <ul>
                          <template x-for="item in filteredCategories">
                            <li class="px-4 py-2 hover:bg-gray-200 cursor-pointer" x-on:click="selectCategory(item)">
                              <span x-text="item.name"></span>
                            </li>
                          </template>
                        </ul>
                      </div>
                    </template>
                  </div>
                  <x-input-error x-show="category_id.error" :messages="$errors->get('category_id')" class="mt-2" />
                </div>
                <div class="mb-3">
                  <x-input-label for="name" value="{{ __('Name *') }}" />
                  <x-text-input id="name" name="name" type="text" class="mt-1 w-full"
                    placeholder="{{ __('Enter Name') }}" x-model="product.value" x-on:keyup="generateSlug()" />
                  <x-input-error x-show="product.error" :messages="$errors->get('name')" class="mt-2" />
                </div>
                <div class="mb-3">
                  <x-input-label for="slug" value="{{ __('Slug') }}" />
                  <x-text-input id="slug" name="slug" type="text" class="mt-1 block w-full"
                    placeholder="{{ __('Enter Slug') }}" x-model="slug.value" :readonly="true" />
                  <x-input-error x-show="category.error" :messages="$errors->get('slug')" class="mt-2" />
                </div>
                <div class="mb-3">
                  <x-input-label for="description" value="{{ __('Description *') }}" />
                  <x-textarea-input id="description" name="description" class="mt-1 w-full"
                    placeholder="{{ __('Enter Description') }}" x-model="description.value" />
                  <x-input-error x-show="description.error" :messages="$errors->get('description')" class="mt-2" />
                </div>
                <div class="mb-3">
                  <x-input-label for="image">
                    {{ __('Image') }} <small x-show="isEdit" class="text-xs text-gray-500">{{ __('Ignore if not
                      changed') }}</small>
                  </x-input-label>
                  <x-file-input id="image" name="image" class="mt-1 block w-full" placeholder="{{ __('Enter Image') }}"
                    x-model="image.value" />
                  <x-input-error x-show="image.error" :messages="$errors->get('image')" class="mt-2" />
                </div>
              </div>
              <!-- Kolom Kanan -->
              <div>
                <div class="mb-3">
                  <x-input-label for="discount_id" value="{{ __('Discount') }}" />
                  <x-text-input id="discount_id" name="discount_id" type="hidden"
                    placeholder="{{ __('Select Discount') }}" class="mt-1" x-model="discount_id" />
                  <div class="relative w-full">
                    <x-text-input id="discount_display" name="discount_display" type="text" x-model="discount"
                      x-on:input="searchDiscount()" class="mt-1" />
                    <template x-if="discount && filteredDiscounts.length > 0">
                      <div
                        class="absolute shadow-xl w-full min-h-48 max-h-48 bg-white z-10 border border-gray-300 mt-1 rounded overflow-y-auto">
                        <ul>
                          <template x-for="item in filteredDiscounts">
                            <li class="px-4 py-2 hover:bg-gray-200 cursor-pointer" x-on:click="selectDiscount(item)">
                              <span x-text="item.name"></span>
                            </li>
                          </template>
                        </ul>
                      </div>
                    </template>
                  </div>
                  <x-input-error x-show="discount_id.error" :messages="$errors->get('discount_id')" class="mt-2" />
                </div>
                <div class="mb-3">
                  <x-input-label for="price" value="{{ __('Price *') }}" />
                  <x-text-input id="price" name="price" type="text" class="mt-1 w-full"
                    placeholder="{{ __('Enter Price') }}" x-model="price.value" />
                  <x-input-error x-show="price.error" :messages="$errors->get('price')" class="mt-2" />
                </div>
                <div class="mb-3">
                  <x-input-label for="stock" value="{{ __('Stock *') }}" />
                  <x-text-input id="stock" name="stock" type="text" class="mt-1 w-full"
                    placeholder="{{ __('Enter Stock') }}" x-model="stock.value" />
                  <x-input-error x-show="stock.error" :messages="$errors->get('stock')" class="mt-2" />
                </div>
                <div class="mb-3">
                  <x-input-label for="is_active" value="{{ __('Status') }}" />
                  <div class="flex items-center space-x-4">
                    <label class="flex items-center">
                      <input type="radio" x-model="is_active" value="true" class="radio" />
                      <span class="ml-2">Active</span>
                    </label>
                    <label class="flex items-center">
                      <input type="radio" x-model="is_active" value="false" class="radio" />
                      <span class="ml-2">Inactive</span>
                    </label>
                  </div>
                  <x-input-error x-show="is_active.error" :messages="$errors->get('is_active')" class="mt-2" />
                </div>
              </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mt-4">
              <x-primary-button class="w-full">
                {{ __('Submit') }}
              </x-primary-button>
              <x-secondary-button class="w-full" x-on:click="$dispatch('close-modal', 'form-product'); resetForm()">
                {{ __('Cancel') }}
              </x-secondary-button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </x-modal>
  @push('scripts')
  <script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('ProductForm', () => ({
            formAction: '{{ route('admin.product.store') }}',
            categories: @json($categories), // Pastikan data dilempar dari backend
            discounts: @json($discounts),
            filteredCategories: [],
            filteredDiscounts: [],
            category: '',
            discount: '',
            category_id: {
                value: '{{ old('category_id') ?? '' }}',
                error: {{ $errors->get('category_id') ? 'true' : 'false' }},
            },
            discount_id: {
                value: '{{ old('discount_id') ?? '' }}',
                error: {{ $errors->get('discount_id') ? 'true' : 'false' }},
            },
            product: {
                value: '{{ old('name') ?? '' }}',
                error: {{ $errors->get('name') ? 'true' : 'false' }},
            },
            slug: {
                value: '{{ old('slug') ?? '' }}',
                error: {{ $errors->get('slug') ? 'true' : 'false' }},
            },
            description: {
                value: '{{ old('description') ?? '' }}',
                error: {{ $errors->get('description') ? 'true' : 'false' }},
            },
            price: {
                value: '{{ old('price') ?? '' }}',
                error: {{ $errors->get('price') ? 'true' : 'false' }},
            },
            stock: {
                value: '{{ old('stock') ?? '' }}',
                error: {{ $errors->get('stock') ? 'true' : 'false' }},
            },
            image: {
                value: '{{ old('image') ?? '' }}',
                error: {{ $errors->get('image') ? 'true' : 'false' }},
            },
            is_active: {
                value: {{ old('is_active') ?? 'true' }},
                error: {{ $errors->get('is_active') ? 'true' : 'false' }},
            },
            isEdit: false,

            setEditData(actionUrl, category_id, discount_id, name, slug, description, price, stock, is_active) {  
                this.formAction = actionUrl;
                this.category_id = category_id;
                this.category = this.categories.find(cat => cat.id == category_id)?.name || '';
                this.discount_id = discount_id;
                this.discount = this.discounts.find(discount => discount.id == discount_id)?.name || '';
                this.product.value = name;
                this.slug.value = slug;
                this.description.value = description;
                this.price.value = price;
                this.stock.value = stock;
                this.is_active = is_active;
                this.isEdit = true;
            },

            resetForm() {
                this.formAction = '{{ route('admin.product.store') }}';
                this.category_id = '';
                this.filteredCategories = [];
                this.category = '';

                this.discount_id = '';
                this.filteredDiscounts = [];
                this.discount = '';

                this.product.value = '';
                this.product.error = false;
                this.slug.value = '';
                this.slug.error = false;

                this.description.value = '';
                this.description.error = false;

                this.price.value = '';
                this.price.error = false;

                this.stock.value = '';
                this.stock.error = false;

                this.image.error = false;
                this.is_active = true;
                this.is_active.error = false;
                this.isEdit = false;
            },

            searchCategory() {
                let search = this.category.toLowerCase();
                this.filteredCategories = this.categories.filter(category => 
                    category.name.toLowerCase().includes(search)
                );
            },

            selectCategory(category) {
                this.category_id = category.id;
                this.category = category.name;
                this.filteredCategories = [];
            },

            searchDiscount() {
                let search = this.discount.toLowerCase();
                this.filteredDiscounts = this.discounts.filter(discount => 
                    discount.name.toLowerCase().includes(search)
                );
            },

            selectDiscount(discount) {
                this.discount_id = discount.id;
                this.discount = discount.name;
                this.filteredDiscounts = [];
            },

            generateSlug() {
                this.slug.value = this.product.value
                    .toLowerCase()
                    .trim()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');
            },

            init() {
                window.addEventListener('reset-form', () => {
                    this.resetForm();
                });

                window.addEventListener('set-edit-data', (event) => {
                    const {
                        actionUrl,
                        category_id,
                        discount_id,
                        name,
                        slug,
                        description,
                        price,
                        stock,
                        is_active
                    } = event.detail;
                    this.setEditData(actionUrl, category_id, discount_id, name, slug, description, price, stock, is_active);
                });
            },
        }));
    });
  </script>
  @endpush
</x-app-layout>