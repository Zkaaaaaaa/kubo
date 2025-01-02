@extends('layouts.client.app')

@section('title', 'Kubo')

@section('content')
    <div class="container mb-5 pb-5">
        <div class="row">
                        {{-- SEARCH BAR --}}
                        <div class="col-md-12 py-3">
                            <form class="form-inline my-2 my-lg-0">
                                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                            </form>
                        </div>
                        {{-- ./SEARCH BAR --}}
                        
                        @foreach ($products as $product)
                            <div class="col-lg-3 col-md-4 col-6 mb-4">
                                <div class="card">
                                    <img class="card-img-top" src="{{ $product->photo }}" alt="Card image cap">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $product->name }}</h5>
                                        <p class="card-text">RP.{{ number_format($product->price) }}</p>
                                        <a href="#" class="btn btn-primary">Beli</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
        </div>
    </div>
@endsection
