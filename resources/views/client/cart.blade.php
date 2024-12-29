@extends('layouts.client.app')

@section('title', 'Detail Product')

@section('content')
    <div class="container mb-5 pb-5">
        <div class="row">
            <form action="" method="POST">
                @csrf

                <div class="col-md-12 mb-3">
                    <h3><b>Keranjangku</b></h3>
                </div>

                @forelse ($carts as $cart)
                    @if ($cart->product)
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <img src="{{ $cart->product->photo }}" alt="{{ $cart->product->name }}"
                                        class="img-thumbnail m-2">
                                    <div>
                                        <h4 class="mb-1"><b>{{ $cart->product->name }}</b></h4>
                                        <p class="mb-4 text-muted">{{ $cart->note }}</p>
                                        <h5><b>Harga: Rp{{ number_format($cart->product->price, 0, ',', '.') }}</b></h5>
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
                    TOTAL: Rp 100.000
                    <span type="submit" class="btn btn-warning">pesan</span>
                </div>
            </form>
        </div>
    </div>
@endsection
