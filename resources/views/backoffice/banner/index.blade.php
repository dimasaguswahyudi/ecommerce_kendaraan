<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Banner') }}
        </h2>
    </x-slot>

    @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    @endpush

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="card bg-white p-5">
                <div class="card-body">
                    <div class="flex justify-end">
                        <x-danger-button x-data="" x-on:click.prevent="
                              $dispatch('open-modal', 'confirm-delete');
                              $dispatch('set-delete-action', '{{ route('admin.banner.destroyAll') }}');
                          ">
                            <span class="material-icons-outlined fs-16">delete</span>
                            {{ __('Delete All') }}
                        </x-danger-button>
                    </div>
                    <div>
                        <form action="{{ route('admin.banner.store') }}" method="POST" enctype="multipart/form-data"
                            class="border-dashed border-2 dropzone" id="image-upload"
                            style="border: 2px rgba(158, 158, 158, 0.3) dashed !important">
                            @csrf
                        </form>
                    </div>
                    <div>
                        <div class="mt-6 flex flex-wrap items-center justify-center gap-3 banner-section"
                            x-data="{ url: null }">
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
              listBanner();
          })

          Dropzone.options.imageUpload = {
              maxFilesize: 1,
              acceptedFiles: ".jpeg,.jpg,.png",
              dictDefaultMessage: `<div class="mb-3"><span class="material-icons-outlined fs-1000">cloud_upload</span></div>
                               <h5>Upload image or drag and drop</h5>
                               <h6 class="text-muted">JPG or PNG</h6><small>Max size: 1 MB</small>`,
              init: function() {
                  this.on("success", function(file) {
                      if (file.status === "success") {
                          setTimeout(() => {
                              this.removeFile(file)
                              setTimeout(() => listBanner(), 1500);
                          }, 1200);
                      }
                  });
                  this.on("addedfile", function(file) {
                      if (file.size > this.options.maxFilesize * 1024 * 1024) {
                          var errorMessage = "The file is too large. The maximum size is " + this.options
                              .maxFilesize + " MB.";
                          file.previewElement.querySelector(".dz-error-message").textContent = errorMessage;
                      }
                  });
              }
          };

          const listBanner = () => {
            let bannerSection = document.querySelector('.banner-section');
            bannerSection.innerHTML = `
                <div class="skeleton h-50 w-full"></div>
                <div class="skeleton h-50 w-full"></div>
            `;

            setTimeout(() => {
                fetch('{{ route('admin.banner.show') }}')
                    .then(response => response.json())
                    .then(data => {
                        let dataHtml = '';

                        if (data.length > 0) {
                            dataHtml += `<div class="grid grid-cols-2 gap-4">`; // Gunakan grid untuk 2 kolom
                            data.forEach(element => {
                                const urlDestroy = "{{ route('admin.banner.destroy', ':id') }}"
                                    .replace(':id', element.id);
                                dataHtml += `
                                    <div class="relative mb-3 banner-card cursor-pointer" data-id="${element.id}">
                                        <figure class="w-full h-50 border border-gray-300 rounded-md overflow-hidden">
                                            <span class="absolute -top-3 -right-1 cursor-pointer bg-red-400 text-white rounded-full w-8 h-8 flex justify-center items-center"
                                                x-on:click.prevent="
                                                    url= '${urlDestroy}';
                                                    $dispatch('open-modal', 'confirm-delete');
                                                    $dispatch('set-delete-action', url);
                                                ">
                                                <span class="material-icons-outlined fs-16">delete</span>
                                            </span>
                                            <img src="{{ asset('storage/${element.name}') }}" alt="${element.name}" class="w-full h-full object-cover" />
                                        </figure>
                                    </div>
                                `;
                            });
                            dataHtml += `</div>`; // Tutup grid
                        } else {
                            dataHtml = `
                                <div class="w-full flex flex-col justify-center items-center">
                                    <figure>
                                        <img src="{{ asset('image/no-data.png') }}" class="w-30 h-24 text-center" alt="no data" />
                                    </figure>
                                    <h3 class="font-semibold text-center">Banner Tidak Tersedia</h3>
                                </div>
                            `;
                        }

                        bannerSection.innerHTML = dataHtml;
                    });
            }, 1000);
        };
          
    </script>
    @endpush
</x-app-layout>