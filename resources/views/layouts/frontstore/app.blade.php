<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="viewport" content="viewport-fit=cover">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Belanja Parts') }}</title>

  <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/logo/Favicon.png') }}">

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&display=swap"
    rel="stylesheet">



  <!-- Font Awwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
    integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- Scripts -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])


  @stack('styles')


  <style>
    html {
      font-family: "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol;
 line-height: 1.15;
      -webkit-text-size-adjust: 100%;
      -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
    }

    .btn {
      border: none;
    }
  </style>
</head>

<body x-data="Filter()">
  @include('layouts.frontstore.partials.navbar')
  <div class="flex" x-init="hasCategories = categories.length > 0">

    {{-- sidebar --}}
    <aside x-show="categories.length > 0"
      class="hidden md:w-[18%] min-h-screen bg-[#ececec] text-primary px-4 py-2 md:flex flex-col fixed top-15 left-0 h-full">
      <div>
        <h1 class="font-bold text-xl px-4 mt-6 mb-0 text-primary-500">Pilih Kategori Barang</h1>
        <div class="divider"></div>
      </div>
      <nav class="flex-1 h-full pb-24 overflow-auto">
        <ul class="menu mx-0">
          <template x-for="(category, index) in categories" :key="index">
            <li class="mb-6">
              <a href="javascript:void(0);" @click="applyFilter('', category.id)" class="block text-primary-500 rounded-none text-[16px] font-semibold px-4 py-2 transition-all duration-700 ease-in-out 
                       hover:bg-neutral-100 hover:py-4 hover:px-4 hover:font-bold hover:text-[18px]"
                :class="selectedCategory === category.id ? 'bg-primary-500 text-white' : ''">
                <span x-text="category.name"></span>
              </a>
            </li>
          </template>
        </ul>
      </nav>
    </aside>

    {{-- main content --}}
    <main class="p-3 w-full wrapper relative z-10" :class="hasCategories ? 'md:ml-[18%]' : 'md:ml-0'">
      @yield('content')
    </main>
  </div>

  @if (session()->has('success') || session()->has('error'))
  <x-toast />
  @endif
  <div class="fixed bottom-[5rem] -right-2 md:right-8 z-50">
    <div class="flex flex-col items-center justify-center">
      <figure class="mb-4">
        <img src="{{ asset('assets/images/box.gif') }}" class="w-20 h-20" alt="checkin sekarang">
      </figure>
      <a target="_blank"
        class="flex items-center justify-center bg-green-500 text-white p-4 rounded-full w-12 h-12 shadow-lg">
        <i class="fa-brands fa-whatsapp text-3xl"></i>
      </a>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  <script>
    const formatRupiah = (number) => {
        return new Intl.NumberFormat("id-ID", {
            currency: "IDR"
        }).format(number);
    }
  </script>
  @stack('scripts')
  @include('layouts.frontstore.partials.js')
</body>

</html>