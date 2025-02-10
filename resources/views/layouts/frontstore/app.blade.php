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

<body>
  @include('layouts.frontstore.partials.navbar')

  <div class="flex" x-data="Filter()">
    @include('layouts.frontstore.partials.sidebar')
    <main class="p-3 w-100 wrapper md:ml-[18%] relative z-10">
      @yield('content')
    </main>
  </div>


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
</body>

</html>