<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-3">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
            <div class="flex flex-wrap gap-3">
                <div class="w-full md:w-[32%] mb-2">
                    <div class="card shadow-md bg-white rounded-md">
                        <div class="card-body p-4">
                            <div class="flex items-center gap-3">
                                <div class="flex items-center justify-center rounded-full w-11 h-11 p-3 bg-primary-100">
                                    <span class="material-icons-outlined text-primary-500">widgets</span>
                                </div>
                                <div>
                                    <h3 class="text-gray-400 uppercase font-extrabold tracking-wider">Total Category
                                    </h3>
                                    <h4 class="text-slate-500 font-semibold text-xl">{{ $totalCategory }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full md:w-[33%] mb-2">
                    <div class="card shadow-md bg-white rounded-md">
                        <div class="card-body p-4">
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex items-center justify-center rounded-full w-11 h-11 p-3 bg-secondary-100">
                                    <span class="material-icons-outlined text-secondary-500">widgets</span>
                                </div>
                                <div>
                                    <h3 class="text-gray-400 uppercase font-extrabold tracking-wider">Total Discount
                                    </h3>
                                    <h4 class="text-slate-500 font-semibold text-xl">{{ $totalProduct }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full md:w-[33%] mb-2">
                    <div class="card shadow-md bg-white rounded-md">
                        <div class="card-body p-4">
                            <div class="flex items-center gap-3">
                                <div class="flex items-center justify-center rounded-full w-11 h-11 p-3 bg-blue-100">
                                    <span class="material-icons-outlined text-blue-500">widgets</span>
                                </div>
                                <div>
                                    <h3 class="text-gray-400 uppercase font-extrabold tracking-wider">Total Product
                                    </h3>
                                    <h4 class="text-slate-500 font-semibold text-xl">{{ $totalDiscount }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>