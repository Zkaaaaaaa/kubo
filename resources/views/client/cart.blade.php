@extends('layouts.client.app')

@section('title', 'Detail Product')

@section('style')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>
@endsection

@section('content')
    <div class="container mb-5 pb-5">
        <div class="d-flex justify-content-center align-items-center">
            <div>

                <div class="col-md-12 my-3">
                    <h3><b>Keranjangku</b></h3>
                </div>

                @php
                    $totalPrice = 0; // Inisialisasi total harga
                @endphp

                @forelse ($carts as $cart)
                    @if ($cart->product)
                        @php
                            $productTotal = $cart->product->price * $cart->quantity; // Hitung total harga per produk
                            $totalPrice += $productTotal; // Tambahkan ke total keseluruhan
                        @endphp
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('storage/' . $cart->product->photo) }}" alt="{{ $cart->product->name }}"
                                        class="img-thumbnail m-3" style="width: 100px; height: 100px;">
                                    <div>
                                        <h4 class="mb-1"><b>{{ $cart->product->name }}</b></h4>
                                        <p class="mb-4 text-muted">Catatan: {{ $cart->note }}</p>
                                        <div class="my-1 d-flex align-items-center">
                                            <button class="btn btn-sm btn-outline-secondary" onclick="updateQuantity({{ $cart->id }}, -1)">-</button>
                                            <span class="mx-2">{{ $cart->quantity }}</span>
                                            <button class="btn btn-sm btn-outline-secondary" onclick="updateQuantity({{ $cart->id }}, 1)">+</button>
                                        </div>
                                        <p class="my-1">Harga: Rp{{ number_format($cart->product->price, 0, ',', '.') }}</p>
                                        <h5 class="font-weight-bold">Total Rp. {{ number_format($productTotal, 0, ',', '.') }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <p class="text-danger">Produk tidak ditemukan.</p>
                    @endif
                @empty
                    
                  <div>
                    <div class=""><img class="card-img-top" src="{{ asset('storage/nasi_goreng.jpeg') }}"
                        alt="Card image cap"
                        style="object-fit: cover; width: 100%; height: 200px;"></div>
                  </div>
                  <h4 class="text-center">Keranjang Anda kosong! yuk pesan dibawah!</h4>
                  <div class="d-flex justify-content-center align-items-center rounded">
                    <a href="{{ route('home') }}" class="btn btn-warning">Pesan Sekarang</a>
                  </div>
                @endforelse

                <div class="d-flex justify-content-between align-items-center bg-light p-3 rounded fixed-bottom mb-5 pb-5">
                    <h4 name="total-price">TOTAL: Rp {{ number_format($totalPrice, 0, ',', '.') }}</h4>
                    <button id="pay-button" class="btn btn-warning">Pesan</button>
                </div>
            </div>
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