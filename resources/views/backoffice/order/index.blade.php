<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Order') }}
    </h2>
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
                  <th>No Transaction</th>
                  <th>Customer Name</th>
                  <th>Customer Phone</th>
                  <th>Customer Address</th>
                  <th>Grand Total</th>
                  <th>Created At</th>
                  <th>Updated At</th>
                  <th class="text-center">Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($orders as $index => $order)
                <tr>
                  <td class="text-center">
                    {{ $loop->iteration + ($orders->currentPage() - 1) * $orders->perPage() }}
                  </td>
                  <td>{{ $order->no_transaction }}</td>
                  <td>{{ $order->Customer->name }}</td>
                  <td>{{ $order->Customer->phone }}</td>
                  <td>{{ $order->Customer->address }}</td>
                  <td>{{ formatRupiah($order->grand_total) }}</td>
                  <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                  <td>{{ $order->updated_at->format('d/m/Y H:i') }}</td>
                  <td>
                    <div class="flex gap-2 justify-center">
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
              {{ $orders->links('pagination::tailwind') }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>