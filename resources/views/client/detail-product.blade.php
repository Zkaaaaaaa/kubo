@extends('layouts.client.app')

@section('title', 'Detail Produk')

@include('client.components.client-styles')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <img class="card-img-top" src="{{ asset('storage/' . $product->photo) }}" alt="{{ $product->name }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title">{{ $product->name }}</h1>
                        <p class="card-text">RP.{{ number_format($product->price) }}</p>
                        <p class="card-text">{{ $product->description }}</p>
                        <form action="{{ route('cart.store', $product->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="quantity">Jumlah</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" required>
                            </div>
                            <div class="form-group">
                                <label for="notes">Catatan</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Tambahkan catatan untuk pesanan Anda (opsional)"></textarea>
                            </div>
                            <button type="submit" class="btn btn-warning">Tambah ke Keranjang</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
