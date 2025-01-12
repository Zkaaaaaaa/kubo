@extends('layouts.client.app')

@section('title', 'Kubo')

@section('style')
    <style>
        .carousel-item img {
            object-fit: cover;
            width: 100%;
            height: 500px;
        }

        @media only screen and (max-width: 780px) {
            .carousel-item img {
                object-fit: cover;
                width: 100%;
                height: 200px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container mb-5 pb-5">
        <div class="row">
            {{-- SELAMAT DATANG --}}
            <div class="col-md-12 py-3">
                <h2><b>Selamat Datang!</b></h2>
                <h4><b>{{ Auth::user()->name }}</b></h4>
            </div>
            {{-- ./SELAMAT DATANG --}}

            {{-- PROMO --}}
            <div class="col-md-12">
                <h4><b>Promo</b></h4>
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="d-block w-100" src="{{ asset('storage/' . $promo->photo_1) }}" alt="First slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="{{ asset('storage/' . $promo->photo_2) }}" alt="Second slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="{{ asset('storage/' . $promo->photo_3) }}" alt="Third slide">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            {{-- ./PROMO --}}

            {{-- SEARCH BAR --}}
            @include('client.components.search-input')
            {{-- ./SEARCH BAR --}}

            {{-- TAB KATEGORI --}}
            <div class="col-12">
                <div class="card card-tabs">
                    <div class="card-header p-0 pt-1">
                        <!-- Wrapper untuk membuat tab dapat digeser -->
                        <div class="overflow-hidden">
                            <div class="overflow-auto d-flex">
                                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist" style="flex-wrap: nowrap;">
                                    @foreach ($categories as $category)
                                        <li class="nav-item">
                                            <a class="nav-link small {{ $loop->first ? 'active' : '' }}"
                                                id="custom-tabs-one-{{ $category->id }}-tab" data-toggle="pill"
                                                href="#custom-tabs-one-{{ $category->id }}" role="tab"
                                                aria-controls="custom-tabs-one-{{ $category->id }}"
                                                aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                                {{ $category->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-one-tabContent">
                            @foreach ($categories as $category)
                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                    id="custom-tabs-one-{{ $category->id }}" role="tabpanel"
                                    aria-labelledby="custom-tabs-one-{{ $category->id }}-tab">
                                    <div class="row">
                                        @foreach ($products->where('category_id', $category->id) as $product)
                                            <div class="col-lg-3 col-md-4 col-6 mb-4">
                                                <div class="card">
                                                    <img class="card-img-top" src="{{ asset('storage/' . $product->photo) }}"
                                                        alt="Card image cap"
                                                        style="object-fit: cover; width: 100%; height: 200px;">
                                                    <div class="card-body">
                                                        <h5 class="card-title">{{ $product->name }}</h5>
                                                        <p class="card-text">RP.{{ number_format($product->price) }}</p>
                                                    </div>
                                                    <a href="{{ route('detail-product', $product->id) }}" class="btn btn-primary">Tambah</a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            {{-- ./TAB KATEGORI --}}
        </div>
    </div>
@endsection
