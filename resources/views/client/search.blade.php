@extends('layouts.client.app')

@section('title', 'Hasil Pencarian')

@include('client.components.client-styles')

@section('content')
    <div class="container">
        <div class="hero-section mb-4">
            <div class="row">
                <div class="col-12">
                    <h2 class="mb-3">Hasil Pencarian</h2>
                    <p class="lead">Menampilkan hasil pencarian untuk "{{ $query }}"</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if(count($products) > 0)
                            <div class="row product-grid">
                                @foreach($products as $product)
                                    <div class="col-lg-3 col-md-4 col-6 mb-4">
                                        <div class="card product-card h-100">
                                            <img class="card-img-top" src="{{ asset('storage/' . $product->photo) }}"
                                                alt="{{ $product->name }}">
                                            <div class="card-body d-flex flex-column">
                                                <h5 class="card-title">{{ $product->name }}</h5>
                                                <p class="card-text">RP.{{ number_format($product->price) }}</p>
                                                <a href="{{ route('detail-product', $product->id) }}" class="btn btn-warning mt-auto">Tambah ke Keranjang</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <h4>Produk tidak ditemukan</h4>
                                <p class="text-muted">Coba cari dengan kata kunci lain</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
