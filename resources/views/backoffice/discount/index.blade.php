<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Discount') }}
      </h2>
      <x-primary-button x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'form-discount');$dispatch('reset-form');"> <span
          class="material-icons-outlined text-[20px]">add</span> {{ __('Create New') }}
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
                  <th>Total Product</th>
                  <th class="text-center">Image</th>
                  <th>Disc Percent</th>
                  <th>Status Active</th>
                  <th>Created At</th>
                  <th>Created By</th>
                  <th>Updated At</th>
                  <th>Updated By</th>
                  <th class="text-center">Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($discounts as $index => $discount)
                <tr>
                  <td class="text-center">
                    {{ $loop->iteration + ($discounts->currentPage() - 1) * $discounts->perPage() }}
                  </td>
                  <td>{{ $discount->Category->name }}</td>
                  <td>{{ $discount->name }}</td>
                  <td>{{ $discount->Product != null ? $discount->Product->count() : '0' }} Pcs</td>
                  <td class="text-center">
                    @if (!empty($discount->image))
                    <div class="avatar">
                      <div class="w-16 rounded">
                        <img src="{{ asset('storage/' . $discount->image) }}" />
                      </div>
                    </div>
                    @else
                    -
                    @endif
                  </td>
                  <td>{{ $discount->disc_percent }}%</td>
                  <td>
                    <div class="badge badge-outline {{ $discount->is_active == 1 ? 'badge-primary' : 'badge-error' }}">
                      {{ $discount->is_active ? 'Active' : 'Inactive' }}
                    </div>
                  </td>
                  <td>{{ $discount->created_at->format('d/m/Y H:i') }}</td>
                  <td>{{ $discount->CreatedBy->name }}</td>
                  <td>{{ $discount->updated_at->format('d/m/Y H:i') }}</td>
                  <td>{{ $discount->UpdatedBy != null ? $discount->UpdatedBy->name : '-' }}</td>
                  <td>
                    <div class="flex gap-2 justify-center">
                      <x-primary-button-icon x-data="" x-on:click.prevent="
                                        $dispatch('open-modal', 'form-discount');
                                        $dispatch('reset-form')
                                        $dispatch('set-edit-data', {
                                            actionUrl: '{{ route('admin.discount.update', $discount->id) }}',
                                            name: '{{ $discount->name }}',
                                            disc_percent: '{{ $discount->disc_percent }}',
                                            is_active: '{{ $discount->is_active == 1 ? 'true' : 'false' }}',
                                            category_id: '{{ $discount->category_id }}',
                                        });
                                    ">
                        <span class="material-icons-outlined text-[14px]">edit</span>
                      </x-primary-button-icon>
                      <x-danger-button-icon class="btn-circle" x-data="" x-on:click.prevent="
                                        $dispatch('open-modal', 'confirm-delete');
                                        $dispatch('set-delete-action', '{{ route('admin.discount.destroy', $discount->id) }}');
                                    ">
                        <span class="material-icons-outlined text-[14px]">delete</span>
                      </x-danger-button-icon>
                    </div>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="12" class="text-center text-slate-500">No Data Found.</td>
                </tr>
                @endforelse
              </tbody>
            </table>
            <div class="mt-4">
              {{ $discounts->links('pagination::tailwind') }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <x-modal name="form-discount" maxWidth="md" :show="$errors->isNotEmpty()" focusable>
    <div class="card">
      <div class="card-body">
        <div x-data="DiscountForm" x-init="init()">
          <form method="post" :action="formAction" enctype="multipart/form-data">
            <h2 class="card-title" x-show="!isEdit">
              Add Discount
            </h2>
            <h2 class="card-title" x-show="isEdit">
              Edit Discount
            </h2>
            @csrf
            <template x-if="isEdit">
              @method('PUT')
            </template>
            <div class="mb-3">
              <x-input-label for="category_id" value="{{ __('Category *') }}" />
              <x-text-input id="category_id" name="category_id" type="hidden" placeholder="{{ __('Select Category') }}"
                class="mt-1" x-model="category_id" />
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
              <x-text-input id="name" name="name" type="text" class="mt-1 w-full" placeholder="{{ __('Enter Name') }}"
                x-model="discount.value" />
              <x-input-error x-show="discount.error" :messages="$errors->get('name')" class="mt-2" />
            </div>
            <div class="mb-3">
              <x-input-label for="disc_percent" value="{{ __('Percent Discount *') }}" />

              <label class="input input-bordered flex items-center gap-2">
                <input id="disc_percent" name="disc_percent" type="number" class="grow border-0"
                  placeholder="{{ __('Enter Percent') }}" x-model="disc_percent.value" min="1" max="100" />
                <span class="material-icons-outlined text-[14px]">percent</span>
              </label>


              <x-input-error x-show="disc_percent.error" :messages="$errors->get('disc_percent')" class="mt-2" />
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
            <div class="mb-3">
              <x-input-label for="image">
                {{ __('Image') }} <small x-show="isEdit" class="text-xs text-gray-500">{{ __('Ignore if not changed')
                  }}</small>
              </x-input-label>
              <x-file-input id="image" name="image" class="mt-1 block w-full" placeholder="{{ __('Enter Image') }}"
                x-model="image.value" />
              <x-input-error x-show="image.error" :messages="$errors->get('image')" class="mt-2" />
            </div>
            <div class="mb-2">
              <x-primary-button class="w-full">
                {{ __('Submit') }}
              </x-primary-button>
            </div>
            <div class="mb-2">
              <x-secondary-button class="w-full" x-on:click="$dispatch('close-modal', 'form-discount'); resetForm()">
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
        Alpine.data('DiscountForm', () => ({
            formAction: '{{ route('admin.discount.store') }}',
            categories: @json($categories), // Pastikan data dilempar dari backend
            filteredCategories: [],
            category: '',
            category_id: {
                value: '{{ old('category_id') ?? '' }}',
                error: {{ $errors->get('category_id') ? 'true' : 'false' }},
            },
            discount: {
                value: '{{ old('name') ?? '' }}',
                error: {{ $errors->get('name') ? 'true' : 'false' }},
            },
            disc_percent: {
                value: '{{ old('disc_percent') ?? '' }}',
                error: {{ $errors->get('disc_percent') ? 'true' : 'false' }},
            },
            image: {
                value: '{{ old('image') ?? '' }}',
                error: {{ $errors->has('image') ? 'true' : 'false' }},
            },
            is_active: '{{ old('is_active') ?? 'true' }}',
            isEdit: false,

            setEditData(actionUrl, name, disc_percent, is_active, category_id) {      
                this.formAction = actionUrl;
                this.discount.value = name;
                this.disc_percent.value = disc_percent;
                this.is_active = is_active;
                this.category_id = category_id;
                this.category = this.categories.find(cat => cat.id == category_id)?.name || '';
                this.isEdit = true;
            },

            resetForm() {
                this.formAction = '{{ route('admin.discount.store') }}';
                this.discount.value = '';
                this.discount.error = false;
                this.disc_percent.value = 1;
                this.disc_percent.error = false;
                this.image.error = false;
                this.is_active = 'true';
                this.category_id = '';
                this.category = '';
                this.isEdit = false;
                this.filteredCategories = [];
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

            init() {
                window.addEventListener('reset-form', () => {
                    this.resetForm();
                });

                window.addEventListener('set-edit-data', (event) => {
                    const { actionUrl, name, disc_percent, is_active, category_id } = event.detail;
                    this.setEditData(actionUrl, name, disc_percent, is_active, category_id);
                });
            },
        }));
    });
  </script>
  @endpush
</x-app-layout>