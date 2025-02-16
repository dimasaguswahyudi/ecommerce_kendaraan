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
            <form method="GET" action="{{ route('admin.dashboard') }}" class="mb-5 flex items-center gap-3">
                <label for="month" class="text-gray-700 font-semibold">Pilih Bulan:</label>
                <input type="month" id="month" name="month" value="{{ request('month', now()->format('Y-m')) }}"
                    class="border rounded-md p-2">

                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                    Filter
                </button>
            </form>

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
                                    <h4 class="text-slate-500 font-semibold text-xl">{{ $totalCategory }} Pcs</h4>
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
                                    <h4 class="text-slate-500 font-semibold text-xl">{{ $totalDiscount }} Pcs</h4>
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
                                    <h4 class="text-slate-500 font-semibold text-xl">{{ $totalProduct }} Pcs</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full md:w-[50%] mb-2">
                    <div class="card shadow-md bg-white rounded-md">
                        <div class="card-body p-4">
                            <div class="flex items-center gap-3">
                                <div class="flex items-center justify-center rounded-full w-11 h-11 p-3 bg-blue-100">
                                    <span class="material-icons-outlined text-blue-500">widgets</span>
                                </div>
                                <div>
                                    <h3 class="text-gray-400 uppercase font-extrabold tracking-wider">Total Transactions
                                    </h3>
                                    <h4 class="text-slate-500 font-semibold text-xl">{{ $totalTransactions->count() }}
                                        Pcs
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full md:w-[49%] mb-2">
                    <div class="card shadow-md bg-white rounded-md">
                        <div class="card-body p-4">
                            <div class="flex items-center gap-3">
                                <div class="flex items-center justify-center rounded-full w-11 h-11 p-3 bg-green-100">
                                    <span class="material-icons-outlined text-green-500">widgets</span>
                                </div>
                                <div>
                                    <h3 class="text-gray-400 uppercase font-extrabold tracking-wider">Total Transactions
                                        By Rupiah
                                    </h3>
                                    <h4 class="text-slate-500 font-semibold text-xl">Rp {{
                                        formatRupiah($totalTransactions->sum('grand_total')) }} Pcs</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full md:w-[50%] mb-2">
                    <div class="card bg-base-100 shadow-md w-full">
                        <div class="card-body">
                            <h2 class="card-title">Best Selling Products</h2>
                            <div class="overflow-x-auto mt-2">
                                <table class="table table-xs  w-full">
                                    <thead>
                                        <tr>
                                            <td></td>
                                            <td>Name</td>
                                            <td>Image</td>
                                            <td>Total Sold</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($bestSellingProducts as $index => $product)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
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
                                            <td>{{ $product->total_sold }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-slate-500">No Data Found.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full md:w-[49%] mb-2">
                    <div class="card bg-base-100 w-full shadow-md">
                        <div class="card-body">
                            <h2 class="card-title">Less popular products</h2>
                            <div class="overflow-x-auto mt-2">
                                <table class="table table-xs  w-full">
                                    <thead>
                                        <tr>
                                            <td></td>
                                            <td>Name</td>
                                            <td>Image</td>
                                            <td>Total Sold</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($leastSellingProducts as $index => $product)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
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
                                            <td>{{ $product->total_sold }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-slate-500">No Data Found.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>