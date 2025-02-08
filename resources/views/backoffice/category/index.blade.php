<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Category') }}
      </h2>
      <x-primary-button x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'form-category');$dispatch('reset-form');"> <span
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
                  <th>Name</th>
                  <th class="text-center">Image</th>
                  <th>Active</th>
                  <th>Created At</th>
                  <th>Updated At</th>
                  <th class="text-center">Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($categories as $index => $category)
                <tr>
                  <td class="text-center">
                    {{ $loop->iteration + ($categories->currentPage() - 1) * $categories->perPage() }}
                  </td>
                  <td>{{ $category->name }}</td>
                  <td class="text-center">
                    @if (!empty($category->image))
                    <div class="avatar">
                      <div class="w-16 rounded">
                        <img src="{{ asset('storage/' . $category->image) }}" />
                      </div>
                    </div>
                    @else
                    -
                    @endif
                  </td>
                  <td>{{ $category->is_active ? 'Active' : 'Inactive' }}</td>
                  <td>{{ $category->created_at->format('d/m/Y H:i') }}</td>
                  <td>{{ $category->updated_at->format('d/m/Y H:i') }}</td>
                  <td>
                    <div class="flex gap-2 justify-center">
                      <x-primary-button-icon x-data="" x-on:click.prevent="
                                        $dispatch('open-modal', 'form-category');
                                        $dispatch('reset-form')
                                        $dispatch('set-edit-data', {
                                            actionUrl: '{{ route('admin.category.update', $category->id) }}',
                                            name: '{{ $category->name }}',
                                            slug: '{{ $category->slug }}',
                                            is_active: '{{ $category->is_active == 1 ? 'true' : 'false' }}',
                                        });
                                    ">
                        <span class="material-icons-outlined text-[14px]">edit</span>
                      </x-primary-button-icon>
                      <x-danger-button-icon class="btn-circle" x-data="" x-on:click.prevent="
                                        $dispatch('open-modal', 'confirm-delete');
                                        $dispatch('set-delete-action', '{{ route('admin.category.destroy', $category->id) }}');
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
              {{ $categories->links('pagination::tailwind') }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <x-modal name="form-category" maxWidth="md" :show="$errors->isNotEmpty()" focusable>
    <div class="card">
      <div class="card-body">
        <div x-data="categoryForm" x-init="init()">
          <form method="post" :action="formAction" enctype="multipart/form-data">
            <h2 class="card-title" x-show="!isEdit">
              Add Category
            </h2>
            <h2 class="card-title" x-show="isEdit">
              Edit Category
            </h2>
            @csrf
            <template x-if="isEdit">
              @method('PUT')
            </template>
            <div class="mb-3">
              <x-input-label for="name" value="{{ __('Name *') }}" />
              <x-text-input id="name" name="name" type="text" class="mt-1 w-full" placeholder="{{ __('Enter Name') }}"
                x-model="category.value" x-on:keyup="generateSlug()" />
              <x-input-error x-show="category.error" :messages="$errors->get('name')" class="mt-2" />
            </div>
            <div class="mb-3">
              <x-input-label for="slug" value="{{ __('Slug') }}" />
              <x-text-input id="slug" name="slug" type="text" class="mt-1 block w-full"
                placeholder="{{ __('Enter Slug') }}" x-model="slug.value" :readonly="true" />
              <x-input-error x-show="category.error" :messages="$errors->get('slug')" class="mt-2" />
            </div>
            <div class="mb-3">
              <x-input-label for="is_active" value="{{ __('Status') }}" />
              <div class="form-control">
                <label class="label cursor-pointer">
                  <span class="label-text">Active</span>
                  <input type="radio" x-model="is_active" value='true' class="radio" />
                </label>
              </div>
              <div class="form-control">
                <label class="label cursor-pointer">
                  <span class="label-text">Inactive</span>
                  <input type="radio" x-model="is_active" value='false' class="radio" />
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
              <x-secondary-button class="w-full" x-on:click="$dispatch('close-modal', 'form-category'); resetForm()">
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
        Alpine.data('categoryForm', () => ({
            formAction: '{{ route('admin.category.store') }}',
            category: {
                value: '{{ old('name') ?? '' }}',
                error: {{ $errors->get('name') ? 'true' : 'false' }},
            },
            slug: {
                value: '{{ old('slug') ?? '' }}',
                error: {{ $errors->get('slug') ? 'true' : 'false' }},
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

            setEditData(actionUrl, name, slug, is_active) {                                
                this.formAction = actionUrl;
                this.category.value = name;
                this.slug.value = slug;
                this.is_active = is_active;
                this.isEdit = true;
            },

            resetForm() {
                this.formAction = '{{ route('admin.category.store') }}';
                this.category.value = '';
                this.category.error = false;
                this.slug.value = '';
                this.slug.error = false;
                this.image.error = false;
                this.is_active = true;
                this.is_active.error = false;
                this.isEdit = false;
            },

            generateSlug() {
                this.slug.value = this.category.value
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
                        name,
                        slug,
                        is_active
                    } = event.detail;
                    this.setEditData(actionUrl, name, slug, is_active);
                });
            },
        }));
    });
  </script>
  @endpush
</x-app-layout>