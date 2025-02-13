@extends('layouts.frontstore.app')

@section('content')
<div class="container mx-auto px-3">
  <div class="grid grid-cols-1 lg:grid-cols-12 gap-4" x-data="cartData()" x-init="onDisplayProduct()">

    <!-- Your Cart -->
    <div class="col-span-12 lg:col-span-8">
      <div class="card w-full shadow-md">
        <div class="card-body w-full">
          <div class="flex justify-between items-center">
            <h2 class="card-title">Keranjang Anda</h2>
            <a href="{{ url('/') }}">
              <secondary-button class="btn btn-secondary text-primary-500 hover:btn-secondary-600 ml-auto">
                <span class="material-icons-outlined">keyboard_arrow_left</span> Kembali Berbelanja
              </secondary-button>
            </a>
          </div>
          <div class="divider"></div>
          <template x-for="(product, index) in displayProduct" :key="index">
            <div class="card card-side bg-base-100 border mb-2">
              <figure class="h-auto">
                <img :src="product.image 
                  ? 'storage/' + product.image 
                  : '{{ asset('assets/images/NoImagePersegi.png') }}'" class="w-40" alt="Product Image">
              </figure>
              <div class="card-body">
                <div class="flex justify-between items-center">
                  <h2 class="card-title" x-text="product.name"></h2>
                  <x-danger-button-icon @click="removeFromCart(product)">
                    <span class="material-icons-outlined text-[14px]">delete</span>
                  </x-danger-button-icon>
                </div>
                <div class="flex justify-between items-center mt-auto w-full">
                  <div class="flex items-center gap-2 w-[20%] border rounded-md px-2 py-1">
                    <button class="btn btn-square btn-sm" @click="decrementQty(product)">
                      <span class="material-icons-outlined text-[18px]">remove</span>
                    </button>

                    <input type="text" x-model="product.qty_in_chart"
                      class="w-full text-center border-none outline-none bg-transparent" readonly />

                    <button class="btn btn-square btn-sm" @click="incrementQty(product)">
                      <span class="material-icons-outlined text-[18px]">add</span>
                    </button>
                  </div>
                  <div class="ml-auto text-right">
                    <h6>Price Item :</h6>
                    <label class="text-red-400 text-xl">
                      Rp. <span
                        x-text="formatRupiah(calculateTotalPrice(product.price, product.discount?.disc_percent, product.qty_in_chart))"></span>
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </template>
        </div>
      </div>
    </div>

    <!-- Summary Order -->
    <div class="col-span-12 lg:col-span-4">
      <div class="card w-full shadow-md  mb-4">
        <div class="card-body">
          <h2 class="card-title">Ringkasan Pesanan</h2>
          <div class="divider"></div>
          <div class="ml-auto text-right">
            <h6>Grand Total :</h6>
            <label class="text-red-400 text-xl">
              Rp. <span x-text="formatRupiah(grand_total)"></span>
            </label>
          </div>
        </div>
      </div>

      <div class="card w-full shadow-md">
        <div class="card-body">
          <h2 class="card-title">Alamat Pengiriman</h2>
          <div class="divider"></div>
          <div class="mb-3">
            <label class="block font-semibold">Nama</label>
            <x-text-input type="text" x-model="name" class="mt-1" placeholder="Masukkan nama" x-model="name.value" />
            <x-input-error x-show="name.error" :messages="$errors->get('name')" class="mt-2" />
          </div>
          <div class="mb-3">
            <label class="block font-semibold">Telepon</label>
            <x-text-input type="text" x-model="phone" class="mt-1" placeholder="Masukkan no telepon"
              x-model="phone.value" />
            <x-input-error x-show="phone.error" :messages="$errors->get('phone')" class="mt-2" />
          </div>
          <div class="mb-3">
            <label class="block font-semibold">Alamat</label>
            <textarea x-model="address.value" name="address" class="textarea textarea-bordered w-full mt-1" rows="3"
              placeholder="Masukkan alamat"></textarea>
            <x-input-error x-show="address.error" :messages="$errors->get('address')" class="mt-2" />
          </div>
          <button @click="submitOrder()" class="btn btn-primary w-full mt-3">Pesan Sekarang</button>
        </div>
      </div>
    </div>

  </div>
</div>


@endsection

@push('scripts')
<script>
  function cartData() {
    return {
        cart: getCarts(),
        displayProduct: [],
        'location_address' : localStorage.getItem('location') ? `${JSON.parse(localStorage.getItem('location')).country_code}`,
        grand_total: 0, // Tambahkan grand_total
        name: {
            value: '{{ old('name') ?? '' }}',
            error: {{ $errors->get('name') ? 'true' : 'false' }},
        },
        phone: {
            value: '{{ old('phone') ?? '' }}',
            error: {{ $errors->get('phone') ? 'true' : 'false' }},
        },
        address: {
            value: '{{ old('address') ?? '' }}',
            error: {{ $errors->get('address') ? 'true' : 'false' }},
        },

        onDisplayProduct() {
            if (this.cart.length > 0) {
                const productId = getCarts().map(item => item.product_id);
                
                fetch(`/cart/show`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                    },
                    body: JSON.stringify({
                        product_ids: productId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    this.displayProduct = data.products.map(product => {
                        const cartItem = this.cart.find(item => item.product_id === product.id);
                        return {
                            ...product,
                            qty_in_chart: cartItem ? cartItem.qty : 1 // Tambahkan qty dari localStorage
                        };
                    });

                    this.updateGrandTotal(); // Update grand total setelah data ditampilkan
                })
                .catch(error => console.error("Error fetching products:", error));
            }
        },

        calculateTotalPrice(price, discount = 0, qty) {
            return qty * price - (price * (discount || 0) / 100);
        },

        updateGrandTotal() {
            this.grand_total = this.displayProduct.reduce((total, product) => {
                return total + this.calculateTotalPrice(product.price, product.discount?.disc_percent, product.qty_in_chart);
            }, 0);
        },

        incrementQty(product) {
            let carts = getCarts();
            let cartItem = carts.find(item => item.product_id === product.id);

            if (!cartItem) {
                showToast('error', 'Produk tidak ditemukan di keranjang');
                return;
            }

            if (product.qty_in_chart < product.stock) {
                cartItem.qty++;
                product.qty_in_chart++;

                localStorage.setItem('carts', JSON.stringify(carts));
                this.updateGrandTotal(); // Update total harga
            } else {
                showToast('error', 'Stok tidak mencukupi');
                product.qty_in_chart = product.stock;
                cartItem.qty = product.stock;
            }
        },

        decrementQty(product) {
            let carts = getCarts();
            let cartItem = carts.find(item => item.product_id === product.id);

            if (!cartItem) {
                showToast('error', 'Produk tidak ditemukan di keranjang');
                return;
            }

            if (product.qty_in_chart > 1) {
                cartItem.qty--;
                product.qty_in_chart--;

                localStorage.setItem('carts', JSON.stringify(carts));
                this.updateGrandTotal(); // Update total harga
            } else {
                carts = carts.filter(item => item.product_id !== product.id);
                localStorage.setItem('carts', JSON.stringify(carts));
                this.onDisplayProduct(); // Refresh daftar produk

                showToast('info', 'Produk dihapus dari keranjang');
                this.updateGrandTotal(); // Update total harga setelah produk dihapus
            }
        },

        removeFromCart(product) {
            let cart = getCarts();
            cart = cart.filter(item => item.product_id !== product.id);
            localStorage.setItem('carts', JSON.stringify(cart));
            this.onDisplayProduct();
            this.updateGrandTotal(); // Update total harga setelah penghapusan
        },
        submitOrder(){            
            if (!this.name.value || !this.phone.value || !this.address.value) {
                showToast('error', 'Harap isi semua field sebelum melakukan pemesanan');
                return;
            }

            if (getCarts().length === 0) {
                showToast('error', 'Keranjang belanja kosong!');
                return;
            }

            let orderData = {
                name: this.name.value,
                phone: this.phone.value,
                address: this.address.value,
                order_detail: getCarts(),
                grand_total: this.grand_total
            };

            fetch('/order', {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                },
                body: JSON.stringify(orderData)
            })
            .then(response => response.json())
            .then(data => {                
                if (data.success) {
                    showToast('success', 'Pesanan berhasil dibuat!');
                    localStorage.removeItem('carts');
                    window.location.href = "/";
                } else {
                    showToast('error', data.message || 'Terjadi kesalahan saat membuat pesanan.');
                }
            })
            .catch(error => {
                console.error("Error:", error);
                showToast('error', 'Gagal menghubungi server.');
            });
        }
    }
}

</script>
@endpush