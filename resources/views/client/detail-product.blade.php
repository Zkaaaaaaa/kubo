@extends('layouts.client.app')

@section('title', 'Detail Product')

@section('content')
    <div class="container mb-5 pb-5">
        <div class="row">
            <form action="{{ route('cart.store', $product->id) }}" method="POST">
                @csrf
                <div class="col-md-12 mb-3">
                    <h3><b>Detail Menu</b></h3>
                    <img class="card-img-top" src="{{ asset('storage/' . $product->photo) }}" alt="Card image cap"
                        style="object-fit: cover; width: 100%; height: 200px;">
                </div>
                <div class="col-md-12 mb-3">
                    <h4><b>{{ $product->name }}</b></h4>
                    <p>{{ $product->description }}</p>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4><b>Rp.{{ number_format($product->price) }}</b></h4>

                        <!-- Fitur jumlah produk -->
                        <div class="d-flex align-items-center">
                            <button type="button" id="minusButton" class="btn btn-secondary btn-sm font-weight-bold"
                                style="height: 38px;">-</button>
                            <input type="number" name="quantity" id="quantity"
                                class="form-control bg-white border-0 text-center mx-2" value="1" min="1"
                                readonly style="width: 50px; height: 38px;">
                            <button type="button" id="plusButton" class="btn btn-secondary btn-sm font-weight-bold"
                                style="height: 38px;">+</button>
                        </div>

                    </div>

                    <div class="mb-3">
                        <h4 class="font-weight-bold" for="note">Catatan :</h4>
                        <textarea class="form-control" name="note" id="note" cols="30" rows="5" placeholder="Masukkan catatan"></textarea>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-warning col-12 mt-5">Masukan Keranjang</button>
                    </div>
            </form>
        </div>
    </div>
    </div>

    <!-- JavaScript untuk logika minus dan plus -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const minusButton = document.getElementById('minusButton');
            const plusButton = document.getElementById('plusButton');
            const quantityInput = document.getElementById('quantity');

            minusButton.addEventListener('click', function() {
                let currentValue = parseInt(quantityInput.value);
                if (currentValue > 1) {
                    quantityInput.value = currentValue - 1;
                }
            });

            plusButton.addEventListener('click', function() {
                let currentValue = parseInt(quantityInput.value);
                quantityInput.value = currentValue + 1;
            });
        });
    </script>
@endsection
