@extends('layouts.client.app')

@section('title', 'Detail Product')

@section('style')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        .cart-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .cart-item {
            transition: all 0.3s ease;
            border-radius: 10px;
            overflow: hidden;
        }

        .cart-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .quantity-control {
            background: #f8f9fa;
            border-radius: 20px;
            padding: 5px 10px;
        }

        .quantity-btn {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .total-section {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .empty-cart {
            text-align: center;
            padding: 40px;
        }

        .empty-cart img {
            max-width: 300px;
            margin-bottom: 20px;
        }

        .btn-warning {
            transition: all 0.3s ease;
            border: none;
            font-size: 0.95rem;
            background-color: #ffc107;
            color: #000;
            border-radius: 8px;
        }

        .btn-warning:hover {
            background-color: #ffca2c;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(255, 193, 7, 0.2);
        }

        .btn-warning:active {
            transform: translateY(0);
        }

        .button-container {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 15px;
        }
    </style>
@endsection

@section('content')
    <div class="container mb-5">
        <div class="cart-container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0"><b>Keranjang Belanja</b></h2>
                <span class="badge bg-warning text-dark">{{ count($carts) }} Item</span>
            </div>

            @php
                $totalPrice = 0;
            @endphp

            @forelse ($carts as $cart)
                @if ($cart->product)
                    @php
                        $productTotal = $cart->product->price * $cart->quantity;
                        $totalPrice += $productTotal;
                    @endphp
                    <div class="card cart-item mb-3" data-cart-id="{{ $cart->id }}">
                        <div class="card-body">
                            <div class="row align-items-center">
                                {{-- Gambar Produk --}}
                                <div class="col-md-3">
                                    <img src="{{ asset('storage/' . $cart->product->photo) }}"
                                        alt="{{ $cart->product->name }}" class="img-fluid rounded"
                                        style="width: 100%; height: 120px; object-fit: cover;">
                                </div>

                                {{-- Detail Produk --}}
                                <div class="col-md-9">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h5 class="mb-1"><b>{{ $cart->product->name }}</b></h5>
                                            <p class="text-muted mb-2">Catatan: {{ $cart->note }}</p>
                                        </div>
                                        {{-- Total Harga Produk (quantity x price) --}}
                                        <h5 class="text-warning mb-0" data-price="{{ $cart->product->price }}">
                                            Rp{{ number_format($productTotal, 0, ',', '.') }}
                                        </h5>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        {{-- Tombol Jumlah dan Hapus --}}
                                        <div class="d-flex align-items-center">
                                            <div class="quantity-control d-flex align-items-center me-3">
                                                <button class="btn btn-sm btn-outline-secondary quantity-btn"
                                                    onclick="updateQuantity({{ $cart->id }}, -1)">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <span class="mx-3">{{ $cart->quantity }}</span>
                                                <button class="btn btn-sm btn-outline-secondary quantity-btn"
                                                    onclick="updateQuantity({{ $cart->id }}, 1)">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                            <button class="btn btn-sm btn-outline-danger"
                                                onclick="confirmDelete({{ $cart->id }})">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>

                                        {{-- Harga per Item --}}
                                        <p class="mb-0">
                                            Rp{{ number_format($cart->product->price, 0, ',', '.') }}/item
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-danger">Produk tidak ditemukan.</div>
                @endif
            @empty
                <div class="empty-cart text-center">
                    <img src="{{ asset('storage/nasi_goreng.jpeg') }}" alt="Empty Cart" class="img-fluid rounded"
                        style="max-width: 300px;">
                    <h4 class="mt-4">Keranjang Anda kosong!</h4>
                    <p class="text-muted mb-4">Yuk pesan makanan favoritmu sekarang!</p>
                    <a href="{{ route('home') }}" class="btn btn-warning btn-lg">Pesan Sekarang</a>
                </div>
            @endforelse


            @if (count($carts) > 0)
                <div class="total-section">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Total Pembayaran</h4>
                        <h4 class="text-warning mb-0">Rp {{ number_format($totalPrice, 0, ',', '.') }}</h4>
                    </div>
                    <div class="button-container">
                        <a href="{{ route('home') }}" class="btn btn-warning text-center py-3">
                            Pesan Lagi
                        </a>
                        <button id="pay-button" class="btn btn-warning text-center py-3">
                            Lanjutkan Pembayaran
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script type="text/javascript">
        function updateQuantity(cartId, change) {
            const cartItem = document.querySelector(`[data-cart-id="${cartId}"]`);
            const quantitySpan = cartItem.querySelector('.quantity-control span');
            const currentQuantity = parseInt(quantitySpan.textContent);
            const newQuantity = currentQuantity + change;

            fetch(`/cart/update/${cartId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({
                        change: change
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (data.deleted) {
                            cartItem.remove();
                            updateCartSummary();
                            checkIfCartIsEmpty();
                        } else {
                            quantitySpan.textContent = data.quantity;

                            // Update total harga item
                            const itemTotalElement = cartItem.querySelector('.text-warning');
                            itemTotalElement.textContent = `Rp${data.total.toLocaleString('id-ID')}`;

                            updateCartSummary();
                        }
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Oops...',
                            text: data.message || 'Terjadi kesalahan.',
                            confirmButtonColor: '#ffc107',
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function confirmDelete(cartId) {
            Swal.fire({
                title: 'Hapus Item?',
                text: "Item ini akan dihapus dari keranjang belanja Anda",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ffc107',
                cancelButtonColor: '#dc3545',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteItem(cartId);
                }
            });
        }

       function deleteItem(cartId) {
    const cartItem = document.querySelector(`[data-cart-id="${cartId}"]`);
    const itemTotalText = cartItem.querySelector('.text-warning');
    const itemTotal = parseInt(itemTotalText.textContent.replace(/[^0-9]/g, ''));

    fetch(`/cart/${cartId}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Hapus item dari DOM
            cartItem.remove();

            // Update badge jumlah item
            const badge = document.querySelector('.badge');
            const count = parseInt(badge.textContent);
            badge.textContent = `${count - 1} Item`;

            // Update total harga
            const totalElement = document.querySelector('.total-section h4.text-warning');
            const currentTotal = parseInt(totalElement.textContent.replace(/[^0-9]/g, ''));
            const newTotal = currentTotal - itemTotal;
            totalElement.textContent = `Rp ${newTotal.toLocaleString('id-ID')}`;

            // Jika tidak ada item lagi, tampilkan view kosong
            if ((count - 1) === 0) {
                document.querySelector('.cart-container').innerHTML = `
                    <div class="empty-cart text-center">
                        <img src="/storage/nasi_goreng.jpeg" class="img-fluid rounded" alt="Empty Cart" />
                        <h4 class="mt-4">Keranjang Anda kosong!</h4>
                        <p class="text-muted mb-4">Yuk pesan makanan favoritmu sekarang!</p>
                        <a href="/" class="btn btn-warning btn-lg">Pesan Sekarang</a>
                    </div>
                `;
            }

            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: data.message,
                confirmButtonColor: '#ffc107',
            });

        } else {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: data.message,
                confirmButtonColor: '#dc3545',
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}


        function updateCartSummary() {
            const cartItems = document.querySelectorAll('.cart-item');
            let total = 0;
            cartItems.forEach(item => {
                const priceElement = item.querySelector('.text-warning');
                const price = parseInt(priceElement.textContent.replace(/[^0-9]/g, ''));
                total += price;
            });

            const totalPriceElement = document.querySelector('.total-section h4.text-warning');
            if (totalPriceElement) {
                totalPriceElement.textContent = `Rp ${total.toLocaleString('id-ID')}`;
            }

            // Update jumlah badge
            const itemCount = document.querySelector('.badge');
            if (itemCount) {
                itemCount.textContent = `${cartItems.length} Item`;
            }
        }

        function checkIfCartIsEmpty() {
            const cartItems = document.querySelectorAll('.cart-item');
            if (cartItems.length === 0) {
                const cartContainer = document.querySelector('.cart-container');
                cartContainer.innerHTML = `
                <div class="empty-cart text-center">
                    <img src="{{ asset('storage/nasi_goreng.jpeg') }}" alt="Empty Cart" class="img-fluid rounded" style="max-width: 300px;">
                    <h4 class="mt-4">Keranjang Anda kosong!</h4>
                    <p class="text-muted mb-4">Yuk pesan makanan favoritmu sekarang!</p>
                    <a href="{{ route('home') }}" class="btn btn-warning btn-lg">Pesan Sekarang</a>
                </div>
            `;
            }
        }

        // Midtrans Payment
        var payButton = document.getElementById('pay-button');
        if (payButton) {
            payButton.addEventListener('click', function() {
                window.snap.pay('{{ $snap_token }}', {
                    onSuccess: function(result) {
                        sendResponseToServer(result);
                    },
                    onPending: function(result) {
                        sendResponseToServer(result);
                    },
                    onError: function(result) {
                        console.log(result);
                    },
                    onClose: function() {
                        console.log('Popup ditutup tanpa menyelesaikan pembayaran');
                    }
                });
            });
        }

        function sendResponseToServer(result) {
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = '/midtrans/finish';

            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'result_data';
            input.value = JSON.stringify(result);
            form.appendChild(input);

            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrfToken;
            form.appendChild(csrfInput);

            document.body.appendChild(form);
            form.submit();
        }
    </script>

@endsection
