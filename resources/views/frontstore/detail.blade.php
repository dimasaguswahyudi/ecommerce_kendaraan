@extends('layouts.frontstore.app')

@section('content')
<div class="container mx-auto px-3">
  <div x-data="productDetail()" class="card bg-base-100 w-full shadow-md">
    <figure class="px-10 pt-10">
      <img :src="product.image ? '/storage/' + product.image : '{{ asset('assets/images/NoImagePersegi.png') }}'"
        alt="Product Image" class="rounded-xl h-60 w-auto object-cover" />
    </figure>
    <div class="card-body">
      <h2 class="card-title" x-text="product.name"></h2>
      <p x-text="product.description"></p>
      <div class="flex gap-2 mt-2">
        <s class="text-gray-500" x-text="'Rp. ' + formatRupiah(product.price)"></s>
        <span class="text-red-500 font-bold"
          x-text="'Rp. ' + formatRupiah(product.price - (product.price * (product.discount?.disc_percent || 0) / 100))">
        </span>
        <small x-text="product.discount?.disc_percent ? product.discount.disc_percent + '%' : ''"></small>
      </div>
      <p class="mt-2 text-gray-600" x-text="'Stock: ' + product.stock + ' pcs'"></p>
      <div class="card-actions mt-4">
        <button class="btn btn-primary w-full"
          @click="addToCart(product.id, product.name, product.price, product.discount?.disc_percent || 0); setLabelCarts(); showToast('success', 'Produk Ditambahkan ke-chart')">
          Tambah Ke Keranjang
        </button>
      </div>
    </div>
  </div>
</div>

<script>
  function productDetail() {
    return {
      product: @json($product), // Data produk dari Laravel dikirim ke Alpine.js
      formatRupiah(value) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value).replace('Rp', '');
      },
      addToCart(id, product, price, discount, qty = 1) {
        let carts = getCarts();
          const productIndex = carts.findIndex(item => item.product_id == id);
          if (productIndex !== -1) {
            carts[productIndex].qty += parseInt(qty);
          } else {
              carts.push({
                  product_id: id,
                  product: product,
                  price: parseInt(price),
                  discount: parseInt(discount),
                  qty: parseInt(qty)
              });
              
          }
          localStorage.setItem('carts', JSON.stringify(carts));
      }
    };
  }
</script>
@endsection