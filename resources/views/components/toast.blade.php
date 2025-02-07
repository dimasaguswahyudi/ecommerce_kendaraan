@php
$alert = '';
$message = '';
$class = ' flex justify-between items-center p-4 rounded shadow-lg text-white';

if (session()->has('success')) {
$alert = 'success';
$message = session()->get('success');
}

if (session()->has('error')) {
$alert = 'error';
$message = session()->get('error');
}
@endphp

<div class="toast toast-top toast-center z-[99999999]" x-data="{ show: true, timeout: null }" x-show="show" x-init="timeout = setTimeout(() => show = false, 2500);
$el.addEventListener('mouseenter', () => clearTimeout(timeout));
$el.addEventListener('mouseleave', () => timeout = setTimeout(() => show = false, 2500));"
  x-transition:enter="transition transform ease-out duration-400" x-transition:enter-start="translate-y-[-100%]"
  x-transition:enter-end="translate-y-0" x-transition:leave="transition transform ease-in duration-300"
  x-transition:leave-start="translate-y-0" x-transition:leave-end="translate-y-[-100%]">
  @if ($alert == 'success')
  <div class="alert alert-success {{ $class }}">
    @elseif ($alert == 'error')
    <div class="alert alert-error {{ $class }}">
      @else
      <div class="alert alert-info {{ $class }}">
        @endif
        <span>{{ $message }}</span>
        <button @click="show = false" class="ml-4 text-lg font-bold text-white hover:text-gray-200">
          &times;
        </button>
      </div>
    </div>