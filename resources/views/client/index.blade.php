@extends('layouts.client.app')

@section('title', 'Kubo')

@section('style')
    <style>
        .hero-section {
            background: linear-gradient(135deg, #dfe9f3 0%, #ffffff 100%);
            padding: 2.5rem 2rem;
            border-radius: 1rem;
            margin-bottom: 2rem;
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.08);
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(6px);
            border: 1px solid rgba(255, 255, 255, 0.4);
        }

        .carousel-item img {
            object-fit: cover;
            width: 100%;
            height: 350px;
            border-radius: 10px;
        }

        .promo-section {
            background: white;
            padding: 1.25rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 1.5rem;
        }

        .product-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-radius: 8px;
            overflow: hidden;
            height: 100%;
            margin-bottom: 0.75rem;
        }

        .product-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        .product-card img {
            object-fit: cover;
            height: 180px;
            width: 100%;
        }

        .product-card .card-body {
            padding: 1rem;
        }

        .product-card .card-title {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
            line-height: 1.2;
        }

        .product-card .card-text {
            color: #e74c3c;
            font-weight: bold;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }

        .product-card .btn {
            width: 100%;
            border-radius: 4px;
            font-weight: 600;
            padding: 0.5rem;
            font-size: 0.9rem;
        }

        .nav-tabs {
            border-bottom: none;
            margin-bottom: 0.5rem;
        }

        .nav-tabs .nav-link {
            border: none;
            color: #6c757d;
            padding: 0.5rem 1rem;
            font-weight: 500;
            position: relative;
            font-size: 0.9rem;
        }

        .nav-tabs .nav-link.active {
            color: #e74c3c;
            background: none;
        }

        .nav-tabs .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: #e74c3c;
        }

        .nav-tabs .nav-link:hover {
            color: #e74c3c;
        }

        .product-grid {
            margin: -0.375rem;
        }

        .product-grid .col {
            padding: 0.375rem;
        }

        @media (max-width: 991.98px) {
            .carousel-item img {
                height: 250px;
            }

            .product-card img {
                height: 160px;
            }
        }

        @media (max-width: 767.98px) {
            .hero-section {
                padding: 1rem 0;
            }

            .carousel-item img {
                height: 200px;
            }

            .product-card img {
                height: 140px;
            }

            .product-card .card-body {
                padding: 0.75rem;
            }

            .product-card .card-title {
                font-size: 0.9rem;
            }

            .product-card .card-text {
                font-size: 1rem;
            }

            .nav-tabs .nav-link {
                padding: 0.4rem 0.75rem;
                font-size: 0.85rem;
            }
        }

        @media (max-width: 575.98px) {
            .carousel-item img {
                height: 150px;
            }

            .product-card img {
                height: 120px;
            }

            .product-card .card-body {
                padding: 0.5rem;
            }

            .product-card .btn {
                padding: 0.4rem;
                font-size: 0.8rem;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container mb-4 pb-4">
        {{-- HERO SECTION --}}
        <div class="hero-section mt-3">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 style="position: relative; z-index: 1;" class="text-2xl font-bold text-gray-800">Selamat Datang di
                            Kubo Kopi!</h2>
                        <h3 class="mb-0"><b>{{ Auth::user()->name }}</b></h3>
                        <p style="position: relative; z-index: 1;" class="text-gray-600 mt-2">
                            Nikmati pengalaman ngopi yang beda – dengan aroma, rasa, dan suasana yang bikin betah.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- PROMO SECTION --}}
        <div class="promo-section">
            <h4 class="mb-3"><b>Promo Spesial</b></h4>
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

        {{-- SEARCH BAR --}}
        @include('client.components.search-input')

        {{-- PRODUCT CATEGORIES --}}
        <div class="col-12 mt-3">
            <div class="card card-tabs">
                <div class="card-header p-0 pt-1">
                    <div class="overflow-hidden">
                        <div class="overflow-auto d-flex">
                            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist" style="flex-wrap: nowrap;">
                                @foreach ($categories as $category)
                                    <li class="nav-item">
                                        <a class="nav-link {{ $loop->first ? 'active' : '' }}"
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
                <div class="card-body p-0">
                    <div class="tab-content" id="custom-tabs-one-tabContent">
                        @foreach ($categories as $category)
                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                id="custom-tabs-one-{{ $category->id }}" role="tabpanel"
                                aria-labelledby="custom-tabs-one-{{ $category->id }}-tab">
                                <div class="row product-grid">
                                    @foreach ($products->where('category_id', $category->id) as $product)
                                        <div class="col-lg-3 col-md-4 col-6">
                                            <div class="card product-card">
                                                <img class="card-img-top" src="{{ asset('storage/' . $product->photo) }}"
                                                    alt="{{ $product->name }}">
                                                <div class="card-body">
                                                    <h5 class="card-title">{{ $product->name }}</h5>
                                                    <p class="card-text">RP.{{ number_format($product->price) }}</p>
                                                </div>
                                                <a href="{{ route('detail-product', $product->id) }}"
                                                    class="btn btn-warning">Tambah ke Keranjang</a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
