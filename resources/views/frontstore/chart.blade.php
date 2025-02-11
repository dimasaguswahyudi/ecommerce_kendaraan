@extends('layouts.frontstore.app')

@section('content')
<div class="container mx-auto px-3">
  <div class="w-full" x-data="cartData()" x-init="onDisplayProduct()">
    <div class="card card-compact bg-base-100 w-full shadow-md">
      <div class="card-body w-full">
        <div class="flex justify-between items-center">
          <h2 class="card-title">Your Cart</h2>
          <a href="{{ url('/') }}">
            <secondary-button class="btn btn-secondary text-primary-500 hover:btn-secondary-600 ml-auto">
              <span class="material-icons-outlined">keyboard_arrow_left</span> Back To Shopping
              </button>
            </secondary-button>
          </a>
        </div>
        <div class="divider"></div>
        <template x-for="(product, index) in displayProduct" :key="index">
          <div class="card card-side bg-base-100 border mb-2">
            <figure class="h-auto">
              <img :src="product.image 
              ? 'storage/' + product.image 
              : '{{ asset('assets/images/NoImagePersegi.png') }}'" class="w-36" alt="Product Image">
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
</div>

@endsection

@push('scripts')
<script>
  function cartData() {
    return{
      cart: getCarts(),
      displayProduct : [],
      onDisplayProduct (){
        if (this.cart.length > 0) {
          const productId = getCarts().map(item => item.product_id);
          console.log(productId);
          
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
          })
          .catch(error => console.error("Error fetching products:", error));
        }
      },
      calculateTotalPrice(price, discount = 0, qty) {          
          return qty * price - (price * (discount || 0) / 100);
      },
      incrementQty(product) {
          const productId = getCarts();
          let cartItem = productId.find(item => item.product_id === product.id);  
          cartItem.qty++;
          localStorage.setItem('carts', JSON.stringify(productId));
          product.qty_in_chart++;
      },
      decrementQty(product) {
        if (product.qty_in_chart > 1) {
            const productId = getCarts();
            let cartItem = productId.find(item => item.product_id === product.id);  
            cartItem.qty--;
            localStorage.setItem('carts', JSON.stringify(productId));
            product.qty_in_chart--;
        }
      },
      removeFromCart(product) {
          let cart = getCarts();
          cart = cart.filter(item => item.product_id !== product.id);
          localStorage.setItem('carts', JSON.stringify(cart));
          this.onDisplayProduct();
      },

    }
  }
</script>
@endpush