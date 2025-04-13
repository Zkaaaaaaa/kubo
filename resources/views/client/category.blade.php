@extends('layouts.client.app')

@section('title', 'Kategori')

@include('client.components.client-styles')

@section('content')
    <div class="container">
        <div class="row">
            <h4 class="card-title mb-4">Produk dalam Kategori "{{ $category->name }}"</h4>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row product-grid">
                            @foreach($products as $product)
                                <div class="col-lg-3 col-md-4 col-6">
                                    <div class="card product-card">
                                        <img class="card-img-top" src="{{ asset('storage/' . $product->photo) }}"
                                            alt="{{ $product->name }}">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $product->name }}</h5>
                                            <p class="card-text">RP.{{ number_format($product->price) }}</p>
                                        </div>
                                        <a href="{{ route('detail-product', $product->id) }}" class="btn btn-warning">Tambah ke Keranjang</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
