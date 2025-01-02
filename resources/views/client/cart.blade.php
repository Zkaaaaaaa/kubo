@extends('layouts.client.app')

@section('title', 'Detail Product')

@section('content')
    <div class="container mb-5 pb-5">
        <div class="row">
            <form action="{{ route('checkout') }}" method="POST">
                @csrf

                <div class="col-md-12 mb-3">
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
                                    <img src="{{ $cart->product->photo }}" alt="{{ $cart->product->name }}"
                                        class="img-thumbnail m-3">
                                    <div>
                                        <h4 class="mb-1"><b>{{ $cart->product->name }}</b></h4>
                                        <p class="mb-4 text-muted">Catatan: {{ $cart->note }}</p>
                                        <p class="my-1">Jumlah: {{ $cart->quantity }}</p>
                                        <p class="my-1">Harga: Rp{{ number_format($cart->product->price, 0, ',', '.') }}</p>
                                        <h5 class="font-weight-bold">Total harga: Rp{{ number_format($productTotal, 0, ',', '.') }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <p class="text-danger">Produk tidak ditemukan.</p>
                    @endif
                @empty
                    <p class="text-center">Keranjang Anda kosong.</p>
                @endforelse

                <div class="d-flex justify-content-between align-items-center bg-light p-3 rounded">
                    <h4>TOTAL: Rp {{ number_format($totalPrice, 0, ',', '.') }}</h4>
                    <button type="submit" class="btn btn-warning">Pesan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
