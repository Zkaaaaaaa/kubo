@extends('layouts.client.app')

@section('title', 'Kubo')

@section('content')
    <div class="container mb-5 pb-5">
        <div class="row">
            <h3><b>{{ $category->name }}</b></h3>
            {{-- SEARCH BAR --}}
            @include('client.components.search-input')
            {{-- ./SEARCH BAR --}}

            @foreach ($products as $product)
            <div class="col-lg-3 col-md-4 col-6 mb-4">
                <div class="card">
                    <img class="card-img-top" src="{{ asset('storage/' . $product->photo) }}"
                        alt="Card image cap"
                        style="object-fit: cover; width: 100%; height: 200px;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">RP.{{ number_format($product->price) }}</p>
                    </div>
                    <a href="{{ route('detail-product', $product->id) }}" class="btn btn-warning">Tambah</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection
