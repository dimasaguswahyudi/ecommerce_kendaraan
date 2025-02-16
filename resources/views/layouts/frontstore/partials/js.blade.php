<script>
    function Filter() {
    return {
      selectedDiscount: null,
      selectedCategory: null,
      your_location: localStorage.getItem('location') ? `${JSON.parse(localStorage.getItem('location')).country_code} - ${JSON.parse(localStorage.getItem('location')).county}` : 'Aktifkan Lokasi',
      products: @json($products ?? []),
      discounts : @json($discounts ?? []),
      categories : @json($categories ?? []),
      total_chart : 0,

      applyFilter(discountId = null, categoryId = null) {
        this.selectedDiscount = discountId;
        this.selectedCategory = categoryId;

        // Request AJAX ke backend tanpa reload
        fetch(`/filter?discount_id=${discountId}&category_id=${categoryId}`)
          .then(response => response.json())
          .then(data => {
            this.products = data.products;
            this.discounts = data.discounts;
          })
          .catch(error => console.error("Error fetching products:", error));
      },
      limitText(text, limit) {
        if (!text) return ''; // Jika teks kosong, kembalikan string kosong
        return text.length > limit ? text.substring(0, limit) + '...' : text;
      },
      addToCart (id, product, price, discount, qty = 1) {                  
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
      },
      getLocation(){
        this.your_location = localStorage.getItem('location') ? `${JSON.parse(localStorage.getItem('location')).country_code} - ${JSON.parse(localStorage.getItem('location')).county}` : null
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(
              (position) => {
                  const latitude = position.coords.latitude;
                  const longitude = position.coords.longitude;

                  fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${latitude}&lon=${longitude}`)
                      .then(response => response.json())
                      .then(data => {
                          if (data.address) {                                
                              this.your_location = `${data.address.country_code} - ${data.address.county}`;
                              localStorage.setItem('location', JSON.stringify(data.address));
                          } else {
                              showToast('error', 'Gagal mendapatkan informasi lokasi')
                          }
                      })
                      .catch(error => {
                          showToast('error', 'Terjadi kesalahan saat mengakses lokasi ' + error)
                      });
              },
              (error) => {
                  switch (error.code) {
                      case error.PERMISSION_DENIED:
                          showToast('error', 'Pengguna menolak permintaan lokasi')
                          break;
                      case error.POSITION_UNAVAILABLE:
                          showToast('error', 'Informasi lokasi tidak tersedia')
                          break;
                      case error.TIMEOUT:
                          showToast('error', 'Permintaan lokasi melebihi batas waktu')
                          break;
                      default:
                          showToast('error', 'Terjadi kesalahan saat mengambil lokasi')
                          break;
                  }
              }
          )
        }
        else{
          showToast('error', 'Geolocation tidak didukung oleh browser Anda')
        }
      },
    }
  }

  
</script>

<script>
    const getCarts = () => {
        return localStorage.getItem('carts') ? JSON.parse(localStorage.getItem('carts')) : [];
    }
    const setLabelCarts = () => {
        const carts = getCarts().length;
        let labelCarts = document.querySelector('.shopping-cart');

        if (!labelCarts) return; // Pastikan elemen ada sebelum mengaksesnya

        labelCarts.innerHTML = ''; // Reset konten sebelumnya

        if (carts > 0) {
            const childLabel = document.createElement('span');
            childLabel.classList.add('shopping-cart-item'); // Tambahkan class
            childLabel.textContent = carts > 99 ? '99+' : carts;

            labelCarts.appendChild(childLabel);
            labelCarts.classList.remove('hidden'); // Tampilkan jika ada item
        } else {
            labelCarts.classList.add('hidden'); // Sembunyikan jika kosong
        }
    };

    const showToast = (type, message) => {
          const toastContainer = document.createElement('div');
          toastContainer.innerHTML = `
              <div class="toast toast-top toast-center z-[99999999]"
                  x-data="{ show: true, timeout: null }"
                  x-show="show"
                  x-init="timeout = setTimeout(() => show = false, 2500);
                          $el.addEventListener('mouseenter', () => clearTimeout(timeout));
                          $el.addEventListener('mouseleave', () => timeout = setTimeout(() => show = false, 2500));"
                  x-transition:enter="transition transform ease-out duration-400"
                  x-transition:enter-start="translate-y-[-100%]"
                  x-transition:enter-end="translate-y-0"
                  x-transition:leave="transition transform ease-in duration-300"
                  x-transition:leave-start="translate-y-0"
                  x-transition:leave-end="translate-y-[-100%]">
                  <div class="alert alert-${type} flex justify-between items-center p-4 rounded shadow-lg text-white">
                      <span>${message}</span>
                      <button @click="show = false" class="ml-4 text-lg font-bold text-white hover:text-gray-200">
                          &times;
                      </button>
                  </div>
              </div>`;

          // Ambil elemen hasil innerHTML
          const toastElement = toastContainer.firstElementChild;

          // Tambahkan toast ke dalam body
          document.body.appendChild(toastElement);

          // Inisialisasi Alpine.js untuk elemen baru
          if (typeof Alpine !== 'undefined' && Alpine.initTree) {
              Alpine.initTree(toastElement);
          }
      }

</script>