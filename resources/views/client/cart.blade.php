@extends('layouts.client.app')

@section('title', 'Detail Product')

@section('style')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>
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
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
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
            position: sticky;
            bottom: 0;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
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
    </style>
@endsection

@section('content')
    <div class="container mb-5 pb-5">
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
                    <div class="card cart-item mb-3">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    <img src="{{ asset('storage/' . $cart->product->photo) }}" 
                                         alt="{{ $cart->product->name }}"
                                         class="img-fluid rounded" 
                                         style="width: 100%; height: 120px; object-fit: cover;">
                                </div>
                                <div class="col-md-9">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h5 class="mb-1"><b>{{ $cart->product->name }}</b></h5>
                                            <p class="text-muted mb-2">Catatan: {{ $cart->note }}</p>
                                        </div>
                                        <h5 class="text-warning mb-0">Rp{{ number_format($productTotal, 0, ',', '.') }}</h5>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <div class="quantity-control d-flex align-items-center">
                                            <button class="btn btn-sm btn-outline-secondary quantity-btn" 
                                                    onclick="updateQuantity({{ $cart->id }}, -1)">-</button>
                                            <span class="mx-3">{{ $cart->quantity }}</span>
                                            <button class="btn btn-sm btn-outline-secondary quantity-btn" 
                                                    onclick="updateQuantity({{ $cart->id }}, 1)">+</button>
                                        </div>
                                        <p class="mb-0">Rp{{ number_format($cart->product->price, 0, ',', '.') }}/item</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-danger">Produk tidak ditemukan.</div>
                @endif
            @empty
                <div class="empty-cart">
                    <img src="{{ asset('storage/nasi_goreng.jpeg') }}" 
                         alt="Empty Cart" 
                         class="img-fluid rounded">
                    <h4 class="mt-4">Keranjang Anda kosong!</h4>
                    <p class="text-muted mb-4">Yuk pesan makanan favoritmu sekarang!</p>
                    <a href="{{ route('home') }}" class="btn btn-warning btn-lg">Pesan Sekarang</a>
                </div>
            @endforelse

            @if(count($carts) > 0)
                <div class="total-section">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Total Pembayaran</h4>
                        <h4 class="text-warning mb-0">Rp {{ number_format($totalPrice, 0, ',', '.') }}</h4>
                    </div>
                    <button id="pay-button" class="btn btn-warning w-100 mt-3 py-3">
                        Lanjutkan Pembayaran
                    </button>
                </div>
            @endif
        </div>
    </div>

    <script type="text/javascript">
        function updateQuantity(cartId, change) {
            fetch(`/cart/update/${cartId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({ change: change }),
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload(); // Refresh halaman untuk memperbarui tampilan keranjang
                    } else {
                        alert(data.message || 'Terjadi kesalahan.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        var payButton = document.getElementById('pay-button');
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
                    console.log('customer closed the popup without finishing the payment');
                }
            });
        });

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